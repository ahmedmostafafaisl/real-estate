<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $starts = fake()->dateTimeBetween('-11 months', '-1 week');
        $ends = (clone $starts)->modify('+1 month');
        $status = $ends < now() ? fake()->randomElement(['expired', 'expired', 'cancelled']) : 'active';

        return [
            'service_provider_id' => ServiceProvider::factory(),
            'subscription_package_id' => SubscriptionPackage::inRandomOrder()->value('id') ?? 1,
            'status' => $status,
            'starts_at' => $starts,
            'ends_at' => $ends,
            'auto_renew' => fake()->boolean(70),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => 'active',
            'starts_at' => now()->subDays(fake()->numberBetween(1, 25)),
            'ends_at' => now()->addDays(fake()->numberBetween(3, 30)),
        ]);
    }
}
