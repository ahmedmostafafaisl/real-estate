<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\PropertyReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyReportFactory extends Factory
{
    protected $model = PropertyReport::class;

    protected static array $reasons = ['سعر مضلّل', 'إعلان مكرر', 'صور غير لائقة', 'اشتباه في احتيال', 'العقار لم يعد متاحاً'];
    protected static array $details = [
        'السعر المعروض هنا يختلف عما أُبلغت به عبر الهاتف.',
        'وجدت نفس الإعلان منشوراً مرتين بأسماء مختلفة.',
        'حاولت التواصل مع المعلن ولم يستجب رغم تكرار المحاولة.',
        null, null,
    ];

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory()->customer(),
            'reason' => fake()->randomElement(self::$reasons),
            'details' => fake()->randomElement(self::$details),
            'status' => fake()->randomElement(['open', 'open', 'resolved', 'dismissed']),
        ];
    }
}
