<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'region_id' => Region::factory(),
            'name' => fake()->randomElement(['الرياض', 'جدة', 'الدمام', 'مكة المكرمة', 'المدينة المنورة']),
            'latitude' => fake()->latitude(16, 32),
            'longitude' => fake()->longitude(34, 50),
            'is_active' => true,
        ];
    }
}
