<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use App\Models\Region;
use App\Models\ServiceProvider;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyLifecycleTest extends TestCase
{
    use RefreshDatabase;

    protected ServiceProvider $provider;

    protected User $adminUser;

    protected City $city;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        // City/Region/Country have no factories in this project (only ever
        // seeded, never factory-generated) — ServiceProviderFactory falls back
        // to City::factory() when none exist, which doesn't exist and would
        // crash. Create the geo chain explicitly, first, before anything
        // that might implicitly need a city.
        $country = Country::create(['code' => 'SAU', 'name' => 'المملكة العربية السعودية']);
        $region = Region::create(['country_id' => $country->id, 'name' => 'منطقة الرياض']);
        $this->city = City::create(['region_id' => $region->id, 'name' => 'الرياض']);

        $providerUser = User::factory()->serviceProviderUser()->create();
        $providerUser->assignRole('service_provider');
        $this->provider = ServiceProvider::factory()->verified()
            ->for($providerUser, 'user')
            ->create(['city_id' => $this->city->id]);

        $this->adminUser = User::factory()->admin()->create();
        $this->adminUser->assignRole('admin');
    }

    protected function makeProperty(array $overrides = []): Property
    {
        $category = PropertyCategory::create(['name' => 'سكني', 'slug' => 'residential-'.uniqid()]);
        $type = PropertyType::create(['property_category_id' => $category->id, 'name' => 'شقة', 'slug' => 'apartment-'.uniqid()]);

        return $this->provider->properties()->create([
            'property_category_id' => $category->id,
            'property_type_id' => $type->id,
            'city_id' => $this->city->id,
            'title' => 'شقة اختبار',
            'slug' => 'test-property-'.uniqid(),
            'listing_type' => 'sale',
            'price' => 500000,
            'status' => 'pending',
            ...$overrides,
        ]);
    }

    public function test_new_listing_starts_as_draft_and_is_not_publicly_visible(): void
    {
        $property = $this->makeProperty(['status' => 'draft']);

        $response = $this->actingAs($this->provider->user)->get('/provider/properties');
        $response->assertOk();
        $response->assertSee($property->title);

        // A draft must never be visible on the public site — only published listings.
        $publicResponse = $this->get('/properties');
        $publicResponse->assertDontSee($property->title);
    }

    public function test_admin_approving_a_pending_property_publishes_it(): void
    {
        $property = $this->makeProperty(['status' => 'pending']);

        $response = $this->actingAs($this->adminUser)->post("/admin/properties/{$property->id}/approve");

        $response->assertRedirect();
        $this->assertSame('published', $property->fresh()->status);
        $this->assertNotNull($property->fresh()->published_at);

        // Now it must actually be visible on the public site.
        $this->get('/properties')->assertSee($property->title);
    }

    public function test_admin_rejecting_a_property_requires_a_reason_and_stores_it(): void
    {
        $property = $this->makeProperty(['status' => 'pending']);

        // No reason provided — should fail validation, not silently reject.
        $this->actingAs($this->adminUser)
            ->post("/admin/properties/{$property->id}/reject", [])
            ->assertSessionHasErrors('reason');
        $this->assertSame('pending', $property->fresh()->status);

        $this->actingAs($this->adminUser)
            ->post("/admin/properties/{$property->id}/reject", ['reason' => 'Photos do not match the description.'])
            ->assertRedirect();

        $property->refresh();
        $this->assertSame('rejected', $property->status);
        $this->assertSame('Photos do not match the description.', $property->rejection_reason);
    }

    public function test_provider_cannot_edit_another_providers_property(): void
    {
        $property = $this->makeProperty();

        $otherProviderUser = User::factory()->serviceProviderUser()->create();
        $otherProviderUser->assignRole('service_provider');
        ServiceProvider::factory()->verified()->for($otherProviderUser, 'user')->create(['city_id' => $this->city->id]);

        $this->actingAs($otherProviderUser)
            ->put("/provider/properties/{$property->id}", ['title' => 'Hijacked title'])
            ->assertForbidden();

        $this->assertNotSame('Hijacked title', $property->fresh()->title);
    }

    public function test_provider_can_delete_their_own_draft_listing(): void
    {
        $property = $this->makeProperty(['status' => 'draft']);

        $this->actingAs($this->provider->user)
            ->delete("/provider/properties/{$property->id}")
            ->assertRedirect();

        $this->assertSoftDeleted('properties', ['id' => $property->id]);
    }
}
