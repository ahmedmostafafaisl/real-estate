<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    protected static array $subjects = [
        'Question about a listing', 'Subscription billing issue', 'Partnership inquiry',
        'Report a problem', 'General feedback', null,
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'subject' => fake()->randomElement(self::$subjects),
            'message' => fake()->paragraph(3),
            'status' => fake()->randomElement(['new', 'new', 'read', 'closed']),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
