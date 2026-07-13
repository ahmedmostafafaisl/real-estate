<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyReportFactory extends Factory
{
    protected $model = PropertyReport::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->customer(),
            'reason' => fake()->randomElement(['Misleading price', 'Duplicate listing', 'Inappropriate photos', 'Fraud suspicion', 'Property no longer available']),
            'details' => fake()->boolean(60) ? fake()->sentence(12) : null,
            'status' => fake()->randomElement(['open', 'open', 'resolved', 'dismissed']),
        ];
    }
}
