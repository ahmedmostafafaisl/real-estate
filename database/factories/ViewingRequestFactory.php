<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use App\Models\ViewingRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewingRequestFactory extends Factory
{
    protected $model = ViewingRequest::class;

    protected static array $notes = [
        'الرجاء التنسيق قبل نصف ساعة من الموعد.',
        'أفضل الزيارة في المساء إن أمكن.',
        'سآتي برفقة أحد أفراد العائلة.',
        null, null, null,
    ];

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->customer(),
            'service_provider_id' => \App\Models\ServiceProvider::factory(),
            'requested_slot' => fake()->dateTimeBetween('-2 months', '+3 weeks'),
            'status' => fake()->randomElement(['requested', 'confirmed', 'completed', 'completed', 'cancelled']),
            'notes' => fake()->randomElement(self::$notes),
        ];
    }
}
