<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    // Kept as a small curated Arabic bank rather than fake()->sentence()/paragraph(),
    // since Faker's Lorem provider has no Arabic variant and would output Latin filler text.
    protected static array $pairs = [
        ['q' => 'هل يمكنني تغيير الباقة بعد الاشتراك؟', 'a' => 'نعم، يمكنك الترقية أو التبديل بين الباقات في أي وقت من صفحة الاشتراك في لوحة التحكم.'],
        ['q' => 'هل تدعم المنصة عقارات خارج المدن الرئيسية؟', 'a' => 'نعمل حالياً على توسيع التغطية الجغرافية تدريجياً بحسب طلب مزوّدي الخدمة والعملاء.'],
        ['q' => 'هل يمكن لأكثر من موظف الوصول لحساب المكتب؟', 'a' => 'نعم، يمكن لمدير المكتب إضافة موظفين من صفحة "الموظفون" في لوحة التحكم.'],
        ['q' => 'ماذا يحدث عند انتهاء الاشتراك دون تجديد؟', 'a' => 'تتحول العقارات المنشورة تلقائياً إلى حالة "منتهي" وتُخفى من نتائج البحث حتى يتم التجديد.'],
        ['q' => 'هل يمكنني حذف حسابي نهائياً؟', 'a' => 'يمكنك التواصل مع الدعم الفني لطلب إغلاق الحساب وحذف بياناتك وفق سياسة الخصوصية.'],
        ['q' => 'كيف أعرف أن مزوّد الخدمة موثوق؟', 'a' => 'ابحث عن شارة "موثّق" في صفحة ملف المزوّد — وتعني أن الإدارة راجعت مستنداته الرسمية.'],
    ];

    public function definition(): array
    {
        $pair = fake()->randomElement(self::$pairs);

        return [
            'question' => $pair['q'],
            'answer' => $pair['a'],
            'sort_order' => fake()->numberBetween(10, 100),
            'is_active' => fake()->boolean(90),
        ];
    }
}
