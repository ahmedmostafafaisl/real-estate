<?php

namespace Database\Seeders;

use App\Models\ProviderDocument;
use App\Models\ProviderEmployee;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserAndProviderSeeder extends Seeder
{
    public function run(): void
    {
        // Admins
        User::factory()->admin()->create(['name' => 'Platform Admin', 'email' => 'admin@keystone.io'])
            ->assignRole('admin');
        User::factory()->admin()->count(2)->create()->each(fn ($u) => $u->assignRole('admin'));

        // Customers
        User::factory()->customer()->count(200)->create()->each(fn ($u) => $u->assignRole('customer'));

        // Service providers (user + profile + documents + employees), weighted toward verified
        ServiceProvider::factory()
            ->count(50)
            ->sequence(
                fn ($seq) => $seq->index < 35 ? ['verification_status' => 'verified', 'verified_at' => now()->subDays(random_int(5, 300))]
                    : ($seq->index < 45 ? ['verification_status' => 'pending', 'verified_at' => null]
                        : ['verification_status' => 'rejected', 'verified_at' => null])
            )
            ->create()
            ->each(function (ServiceProvider $provider) {
                $provider->user->assignRole('service_provider');

                ProviderDocument::factory()->count(random_int(1, 3))->for($provider, 'serviceProvider')->create();
                ProviderEmployee::factory()->count(random_int(1, 5))->for($provider, 'serviceProvider')->create();
            });
    }
}
