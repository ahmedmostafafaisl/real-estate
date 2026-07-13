<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $providerIds = ServiceProvider::pluck('id');
        $featureIds = PropertyFeature::pluck('id');

        if ($providerIds->isEmpty() || $featureIds->isEmpty()) {
            $this->command?->warn('Skipping PropertySeeder: run UserAndProviderSeeder and PropertyTaxonomySeeder first.');
            return;
        }

        Property::factory()
            ->count(600)
            ->create()
            ->each(function (Property $property) use ($providerIds, $featureIds) {
                $property->service_provider_id = $providerIds->random();
                $property->save();

                $property->features()->attach(
                    $featureIds->random(random_int(2, 6))->all()
                );
            });
    }
}
