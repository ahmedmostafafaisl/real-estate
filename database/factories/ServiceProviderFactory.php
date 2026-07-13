<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceProviderFactory extends Factory
{
    protected $model = ServiceProvider::class;

    protected static array $officeWords = [
        'Alnakhil', 'Horizon', 'Dar Al Bina', 'Coastal', 'Falcon', 'Zahra', 'Marwan & Sons',
        'Union', 'Silk Route', 'Al Waha', 'Bright Key', 'Sabeel', 'Al Mashariq', 'Nawras',
        'Dunes', 'Al Reef', 'Cedar', 'Qasr', 'Al Yamamah', 'Skyline', 'Al Basateen', 'Vantage',
    ];
    protected static array $officeSuffixes = ['Realty', 'Properties', 'Developments', 'Holdings', 'Group', 'Estates', 'Homes', 'Land Co.'];

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->serviceProviderUser(),
            'office_name' => fake()->randomElement(self::$officeWords) . ' ' . fake()->randomElement(self::$officeSuffixes),
            'provider_type' => fake()->randomElement(['agency', 'broker', 'owner', 'developer']),
            'commercial_register_no' => fake()->boolean(80) ? fake()->numerify('##########') : null,
            'license_no' => fake()->boolean(70) ? 'LIC-' . fake()->numerify('#####') : null,
            'city_id' => City::inRandomOrder()->value('id') ?? City::factory(),
            'address' => fake()->streetAddress(),
            'logo' => null,
            'bio' => fake()->boolean(75) ? fake()->paragraph(2) : null,
            'verification_status' => fake()->randomElement(['pending', 'verified', 'verified', 'verified', 'rejected']),
            'verified_at' => null,
            'commission_rate' => fake()->randomElement([1.5, 2.0, 2.0, 2.5, 3.0]),
            'notification_preferences' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (ServiceProvider $provider) {
            if ($provider->verification_status === 'verified' && ! $provider->verified_at) {
                $provider->verified_at = fake()->dateTimeBetween('-1 year', 'now');
            }
        });
    }

    public function verified(): static
    {
        return $this->state(fn () => ['verification_status' => 'verified', 'verified_at' => fake()->dateTimeBetween('-1 year', 'now')]);
    }

    public function pending(): static
    {
        return $this->state(fn () => ['verification_status' => 'pending', 'verified_at' => null]);
    }
}
