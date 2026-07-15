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
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    protected Property $property;

    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $country = Country::create(['code' => 'SAU', 'name' => 'المملكة العربية السعودية']);
        $region = Region::create(['country_id' => $country->id, 'name' => 'منطقة الرياض']);
        $city = City::create(['region_id' => $region->id, 'name' => 'الرياض']);

        $providerUser = User::factory()->serviceProviderUser()->create();
        $providerUser->assignRole('service_provider');
        $provider = ServiceProvider::factory()->verified()->for($providerUser, 'user')->create(['city_id' => $city->id]);

        $category = PropertyCategory::create(['name' => 'سكني', 'slug' => 'residential-'.uniqid()]);
        $type = PropertyType::create(['property_category_id' => $category->id, 'name' => 'شقة', 'slug' => 'apartment-'.uniqid()]);

        $this->property = $provider->properties()->create([
            'property_category_id' => $category->id,
            'property_type_id' => $type->id,
            'city_id' => $city->id,
            'title' => 'عقار مفضّل للاختبار',
            'slug' => 'favorite-test-'.uniqid(),
            'listing_type' => 'sale',
            'price' => 300000,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->customer = User::factory()->customer()->create(['is_active' => true]);
        $this->customer->assignRole('customer');
    }

    public function test_guest_cannot_toggle_a_favorite(): void
    {
        $this->postJson("/api/properties/{$this->property->id}/favorite")
            ->assertUnauthorized();
    }

    public function test_customer_can_favorite_and_unfavorite_a_property(): void
    {
        Sanctum::actingAs($this->customer);

        // First call favorites it.
        $this->postJson("/api/properties/{$this->property->id}/favorite")
            ->assertOk()
            ->assertJson(['favorited' => true]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->customer->id,
            'property_id' => $this->property->id,
        ]);

        // Second call un-favorites it — it's a toggle, not a one-way action.
        $this->postJson("/api/properties/{$this->property->id}/favorite")
            ->assertOk()
            ->assertJson(['favorited' => false]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->customer->id,
            'property_id' => $this->property->id,
        ]);
    }

    public function test_favorites_list_only_shows_the_authenticated_users_own_favorites(): void
    {
        Sanctum::actingAs($this->customer);
        $this->postJson("/api/properties/{$this->property->id}/favorite");

        $otherCustomer = User::factory()->customer()->create(['is_active' => true]);
        $otherCustomer->assignRole('customer');
        Sanctum::actingAs($otherCustomer);

        $response = $this->getJson('/api/favorites');
        $response->assertOk();
        $response->assertJsonCount(0, 'data');
    }

    public function test_property_resource_reports_is_favorited_for_the_current_user(): void
    {
        Sanctum::actingAs($this->customer);
        $this->postJson("/api/properties/{$this->property->id}/favorite");

        $this->getJson("/api/properties/{$this->property->id}")
            ->assertOk()
            ->assertJsonPath('data.is_favorited', true);
    }
}
