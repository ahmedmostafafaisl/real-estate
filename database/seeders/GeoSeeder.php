<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Database\Seeder;

class GeoSeeder extends Seeder
{
    public function run(): void
    {
        $sa = Country::firstOrCreate(['code' => 'SAU'], ['name' => 'Saudi Arabia']);

        $regions = [
            'Riyadh Region' => ['Riyadh'],
            'Makkah Region' => ['Jeddah', 'Mecca'],
            'Eastern Province' => ['Dammam', 'Khobar'],
            'Madinah Region' => ['Medina'],
            'Asir Region' => ['Abha'],
        ];

        foreach ($regions as $regionName => $cities) {
            $region = Region::firstOrCreate(['country_id' => $sa->id, 'name' => $regionName]);
            foreach ($cities as $cityName) {
                City::firstOrCreate(['region_id' => $region->id, 'name' => $cityName]);
            }
        }
    }
}
