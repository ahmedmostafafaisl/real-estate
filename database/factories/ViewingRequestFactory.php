<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use App\Models\ViewingRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewingRequestFactory extends Factory
{
    protected $model = ViewingRequest::class;

    public function definition(): array
    {
        $property = Property::factory();

        return [
            'property_id' => $property,
            'user_id' => User::factory()->customer(),
            'service_provider_id' => \App\Models\ServiceProvider::factory(),
            'requested_slot' => fake()->dateTimeBetween('-2 months', '+3 weeks'),
            'status' => fake()->randomElement(['requested', 'confirmed', 'completed', 'completed', 'cancelled']),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
