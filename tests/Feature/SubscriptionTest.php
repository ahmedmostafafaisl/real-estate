<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\ServiceProvider;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    protected ServiceProvider $provider;

    protected SubscriptionPackage $package;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);

        $country = Country::create(['code' => 'SAU', 'name' => 'المملكة العربية السعودية']);
        $region = Region::create(['country_id' => $country->id, 'name' => 'منطقة الرياض']);
        $city = City::create(['region_id' => $region->id, 'name' => 'الرياض']);

        $providerUser = User::factory()->serviceProviderUser()->create();
        $providerUser->assignRole('service_provider');
        $this->provider = ServiceProvider::factory()->verified()->for($providerUser, 'user')->create(['city_id' => $city->id]);

        $this->package = SubscriptionPackage::create([
            'slug' => 'pro', 'name' => 'احترافية', 'price' => 399,
            'listing_limit' => 40, 'featured_listing_limit' => 5, 'billing_cycle' => 'monthly',
        ]);
    }

    public function test_subscribing_creates_an_active_subscription_and_an_unpaid_invoice(): void
    {
        $response = $this->actingAs($this->provider->user)
            ->post('/provider/subscription/subscribe', ['subscription_package_id' => $this->package->id]);

        $response->assertRedirect();

        $this->assertDatabaseHas('subscriptions', [
            'service_provider_id' => $this->provider->id,
            'subscription_package_id' => $this->package->id,
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('invoices', [
            'service_provider_id' => $this->provider->id,
            'status' => 'unpaid',
            'subtotal' => 399,
        ]);
    }

    public function test_subscribing_to_a_new_plan_cancels_the_previous_active_one(): void
    {
        $basic = SubscriptionPackage::create([
            'slug' => 'basic', 'name' => 'أساسية', 'price' => 149,
            'listing_limit' => 10, 'featured_listing_limit' => 0, 'billing_cycle' => 'monthly',
        ]);

        $this->actingAs($this->provider->user)->post('/provider/subscription/subscribe', ['subscription_package_id' => $basic->id]);
        $firstSubscriptionId = $this->provider->subscriptions()->where('status', 'active')->first()->id;

        $this->actingAs($this->provider->user)->post('/provider/subscription/subscribe', ['subscription_package_id' => $this->package->id]);

        // The old one must be cancelled, not left active alongside the new one —
        // otherwise a provider could end up with two simultaneously "active"
        // subscriptions, which the rest of the app (listing limits, dashboard
        // stats) assumes never happens.
        $this->assertDatabaseHas('subscriptions', ['id' => $firstSubscriptionId, 'status' => 'cancelled']);
        $this->assertSame(1, $this->provider->subscriptions()->where('status', 'active')->count());
    }

    public function test_subscribing_requires_a_valid_package_id(): void
    {
        $this->actingAs($this->provider->user)
            ->post('/provider/subscription/subscribe', ['subscription_package_id' => 99999])
            ->assertSessionHasErrors('subscription_package_id');

        $this->assertDatabaseCount('subscriptions', 0);
    }

    public function test_customer_cannot_access_the_provider_subscription_page(): void
    {
        $customer = User::factory()->customer()->create();
        $customer->assignRole('customer');

        $this->actingAs($customer)->get('/provider/subscription')->assertForbidden();
    }
}
