<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyReport;
use App\Models\Review;
use App\Models\User;
use App\Models\ViewingRequest;
use Illuminate\Database\Seeder;

class EngagementSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('user_type', 'customer')->get();
        $properties = Property::whereIn('status', ['published', 'sold', 'rented'])->get();

        if ($customers->isEmpty() || $properties->isEmpty()) {
            $this->command?->warn('Skipping EngagementSeeder: seed customers and properties first.');
            return;
        }

        $pick = fn () => $properties->random();
        $pickUser = fn () => $customers->random();

        collect(range(1, 400))->each(function () use ($pick, $pickUser) {
            Inquiry::factory()->for($pick(), 'property')->for($pickUser(), 'user')->create();
        });

        collect(range(1, 250))->each(function () use ($pick, $pickUser) {
            $property = $pick();
            ViewingRequest::factory()
                ->for($property, 'property')
                ->for($pickUser(), 'user')
                ->create(['service_provider_id' => $property->service_provider_id]);
        });

        collect(range(1, 300))->each(function () use ($pick, $pickUser) {
            Review::factory()->for($pick(), 'property')->for($pickUser(), 'user')->create();
        });

        collect(range(1, 50))->each(function () use ($pick, $pickUser) {
            PropertyReport::factory()->for($pick(), 'property')->for($pickUser(), 'user')->create();
        });
    }
}
