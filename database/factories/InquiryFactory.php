<?php

namespace Database\Factories;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;

    protected static array $messages = [
        "Is this property still available?",
        "Can I schedule a viewing this week?",
        "What's the final price — is it negotiable?",
        "Does it include parking and storage?",
        "How far is it from the nearest metro station?",
        "Is the price inclusive of service charges?",
        "Can you share more photos of the kitchen?",
        "Is financing available through your office?",
    ];

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->customer(),
            'message' => fake()->randomElement(self::$messages),
            'status' => fake()->randomElement(['new', 'new', 'responded', 'closed']),
        ];
    }
}
