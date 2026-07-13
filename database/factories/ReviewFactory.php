<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    protected static array $comments = [
        'Great location, responsive agent throughout.', 'Photos didn\'t quite match the actual unit.',
        'Smooth viewing process, would recommend this provider.', 'Price changed after the visit — a bit disappointing.',
        'Exactly as described, very happy with the purchase.', 'Agent was slow to respond to follow-up questions.',
        'Excellent condition, move-in ready.', 'Good value for the area.',
    ];

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->customer(),
            'rating' => fake()->numberBetween(2, 5),
            'comment' => fake()->randomElement(self::$comments),
            'status' => fake()->randomElement(['published', 'published', 'published', 'pending', 'rejected']),
        ];
    }
}
