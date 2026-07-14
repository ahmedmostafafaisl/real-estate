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
        'موقع ممتاز والمكتب تجاوب سريعاً معنا.', 'الصور لم تطابق تماماً الوحدة الفعلية.',
        'تجربة معاينة سلسة، أنصح بالتعامل مع هذا المزوّد.', 'تغيّر السعر بعد الزيارة، الأمر كان مخيباً بعض الشيء.',
        'العقار مطابق تماماً للوصف، سعيد جداً بالصفقة.', 'المكتب كان بطيئاً في الرد على أسئلة المتابعة.',
        'حالة ممتازة وجاهز للسكن مباشرة.', 'قيمة جيدة مقارنة بأسعار المنطقة.',
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
