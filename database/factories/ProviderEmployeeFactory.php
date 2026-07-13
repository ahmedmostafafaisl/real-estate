<?php

namespace Database\Factories;

use App\Models\ProviderEmployee;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderEmployeeFactory extends Factory
{
    protected $model = ProviderEmployee::class;

    public function definition(): array
    {
        return [
            'service_provider_id' => ServiceProvider::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+9665' . fake()->unique()->numerify('########'),
            'job_title' => fake()->randomElement(['Sales agent', 'Office coordinator', 'Leasing consultant', 'Marketing lead', 'Operations manager']),
            'is_active' => fake()->boolean(85),
        ];
    }
}
