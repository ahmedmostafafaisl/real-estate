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
        'هل هذا العقار متاح حالياً؟',
        'هل يمكنني حجز موعد لمعاينته هذا الأسبوع؟',
        'ما هو السعر النهائي، وهل هو قابل للتفاوض؟',
        'هل يشمل السعر موقف سيارات ومستودعاً؟',
        'كم تبعد المسافة عن أقرب محطة مترو؟',
        'هل السعر شامل رسوم الخدمات؟',
        'هل يمكن إرسال صور إضافية للمطبخ؟',
        'هل يتوفر تمويل عبر مكتبكم؟',
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
