<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => fake()->sentence(6) . '?',
            'answer' => fake()->paragraph(2),
            'sort_order' => fake()->numberBetween(10, 100),
            'is_active' => fake()->boolean(90),
        ];
    }
}
