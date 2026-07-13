<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\PropertyType;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = \App\Models\Property::class;

    protected static array $adjectives = ['Modern', 'Spacious', 'Cozy', 'Luxury', 'Newly renovated', 'Elegant', 'Charming', 'Contemporary'];

    public function definition(): array
    {
        $type = PropertyType::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();
        $district = $city ? $city->districts()->inRandomOrder()->first() : null;

        $bedrooms = fake()->boolean(80) ? fake()->numberBetween(1, 6) : null;
        $title = trim(fake()->randomElement(self::$adjectives) . ' ' . ($type->name ?? 'Property') .
            ($bedrooms ? " {$bedrooms}BR" : '') . ' in ' . ($city->name ?? 'the city'));

        $status = fake()->randomElement([
            'draft', 'pending', 'published', 'published', 'published', 'published',
            'sold', 'rented', 'expired', 'rejected',
        ]);

        return [
            'service_provider_id' => ServiceProvider::factory(),
            'property_category_id' => $type->property_category_id ?? 1,
            'property_type_id' => $type->id ?? 1,
            'city_id' => $city->id ?? 1,
            'district_id' => $district?->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(6)),
            'description' => fake()->paragraphs(3, true),
            'listing_type' => fake()->randomElement(['sale', 'rent']),
            'price' => fake()->numberBetween(150, 2500) * 1000,
            'area_sqm' => fake()->numberBetween(60, 650),
            'bedrooms' => $bedrooms,
            'bathrooms' => $bedrooms ? min($bedrooms, fake()->numberBetween(1, 5)) : null,
            'dynamic_attributes' => null,
            'latitude' => fake()->latitude(16, 32),
            'longitude' => fake()->longitude(34, 50),
            'status' => $status,
            'rejection_reason' => $status === 'rejected' ? fake()->randomElement([
                'Photos do not match the description.', 'Price appears inconsistent with the market.',
                'Missing required commercial documentation.',
            ]) : null,
            'is_featured' => fake()->boolean(15),
            'published_at' => in_array($status, ['published', 'sold', 'rented', 'expired']) ? fake()->dateTimeBetween('-6 months', 'now') : null,
            'expires_at' => $status === 'expired' ? fake()->dateTimeBetween('-2 months', '-1 day') : ($status === 'published' ? fake()->dateTimeBetween('+1 week', '+6 months') : null),
            'views_count' => fake()->numberBetween(0, 4500),
            'created_at' => fake()->dateTimeBetween('-8 months', 'now'),
        ];
    }
}
