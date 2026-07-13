<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Seeder;

class SubscriptionPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Basic', 'price' => 149, 'listing_limit' => 10, 'featured_listing_limit' => 0,
                'perks' => ['10 active listings', 'Standard support', 'Basic analytics']],
            ['name' => 'Pro', 'price' => 399, 'listing_limit' => 40, 'featured_listing_limit' => 5,
                'perks' => ['40 active listings', '5 featured slots/mo', 'Priority support', 'Advanced analytics']],
            ['name' => 'Enterprise', 'price' => 999, 'listing_limit' => 999, 'featured_listing_limit' => 25,
                'perks' => ['Unlimited listings', '25 featured slots/mo', 'Dedicated manager', 'API access']],
        ];

        foreach ($packages as $p) {
            SubscriptionPackage::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($p['name'])],
                [...$p, 'billing_cycle' => 'monthly']
            );
        }
    }
}
