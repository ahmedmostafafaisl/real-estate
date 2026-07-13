<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+9665'.fake()->unique()->numerify('########'),
            'email_verified_at' => now(),
            'password' => Hash::make('  '),
            'user_type' => 'customer',
            'avatar' => null,
            'is_active' => fake()->boolean(92),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['user_type' => 'admin', 'is_active' => true]);
    }

    public function customer(): static
    {
        return $this->state(fn () => ['user_type' => 'customer']);
    }

    public function serviceProviderUser(): static
    {
        return $this->state(fn () => ['user_type' => 'service_provider', 'is_active' => true]);
    }
}
