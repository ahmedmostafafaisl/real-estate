<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    protected static array $maleFirst = ['خالد', 'عبدالله', 'فيصل', 'ماجد', 'سلطان', 'يوسف'];
    protected static array $femaleFirst = ['سارة', 'نورة', 'ريم', 'هند', 'دانة', 'لمياء'];
    protected static array $family = ['العتيبي', 'القحطاني', 'الحربي', 'الدوسري', 'الشمري'];

    protected static array $subjects = [
        'استفسار عن أحد العقارات', 'مشكلة في فوترة الاشتراك', 'استفسار عن شراكة',
        'الإبلاغ عن مشكلة', 'ملاحظات عامة', null,
    ];
    protected static array $messages = [
        'أرغب بمزيد من التفاصيل حول عقار شاهدته على المنصة، هل يمكن التواصل معي؟',
        'واجهت مشكلة في عملية الدفع الخاصة بالاشتراك، هل يمكن المساعدة؟',
        'نمثل شركة استشارات عقارية ونرغب بمناقشة إمكانية الشراكة معكم.',
        'لاحظت أن أحد الإعلانات يحتوي على معلومات غير دقيقة، أرفق تفاصيله في حال الحاجة.',
        'تجربتي مع المنصة كانت جيدة بشكل عام، أشكركم على الجهد المبذول.',
        'هل تتوفر خدمة دعم عبر الهاتف بجانب البريد الإلكتروني؟',
    ];

    public function definition(): array
    {
        $isMale = fake()->boolean();
        $name = fake()->randomElement($isMale ? self::$maleFirst : self::$femaleFirst) . ' ' . fake()->randomElement(self::$family);

        return [
            'name' => $name,
            'email' => fake()->safeEmail(),
            'subject' => fake()->randomElement(self::$subjects),
            'message' => fake()->randomElement(self::$messages),
            'status' => fake()->randomElement(['new', 'new', 'read', 'closed']),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
