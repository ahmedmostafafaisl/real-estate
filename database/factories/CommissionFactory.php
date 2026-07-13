<?php

namespace Database\Factories;

use App\Models\Commission;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommissionFactory extends Factory
{
    protected $model = Commission::class;

    public function definition(): array
    {
        $dealValue = fake()->numberBetween(150, 2500) * 1000;
        $rate = fake()->randomElement([1.5, 2.0, 2.5, 3.0]);
        $status = fake()->randomElement(['paid', 'paid', 'pending']);

        return [
            'property_id' => Property::factory(),
            'service_provider_id' => \App\Models\ServiceProvider::factory(),
            'deal_type' => fake()->randomElement(['sold', 'rented']),
            'deal_value' => $dealValue,
            'commission_rate' => $rate,
            'commission_amount' => round($dealValue * $rate / 100, 2),
            'status' => $status,
            'paid_at' => $status === 'paid' ? fake()->dateTimeBetween('-6 months', 'now') : null,
        ];
    }
}
