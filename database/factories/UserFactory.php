<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static array $maleFirst = [
        'أحمد', 'محمد', 'عبدالله', 'خالد', 'فهد', 'سعود', 'عمر', 'يوسف', 'إبراهيم', 'سلطان',
        'فيصل', 'ماجد', 'تركي', 'بندر', 'نايف', 'ناصر', 'سعد', 'طلال', 'وليد', 'هشام',
    ];
    protected static array $femaleFirst = [
        'نورة', 'سارة', 'ريم', 'لجين', 'مها', 'عبير', 'هند', 'أمل', 'دانة', 'لمياء',
        'رنا', 'شهد', 'غادة', 'منى', 'وعد', 'جود', 'رزان', 'لينا', 'آلاء', 'بشاير',
    ];
    protected static array $family = [
        'القحطاني', 'الغامدي', 'العتيبي', 'الدوسري', 'الشهري', 'الحربي', 'المطيري',
        'السبيعي', 'الزهراني', 'العنزي', 'القرني', 'الشمري', 'البقمي', 'الرشيدي', 'السلمي',
    ];

    public function definition(): array
    {
        $isMale = fake()->boolean();
        $name = fake()->randomElement($isMale ? self::$maleFirst : self::$femaleFirst) . ' ' . fake()->randomElement(self::$family);

        return [
            'name' => $name,
            // Emails stay Latin-charset — standard practice even on Arabic-first platforms,
            // and avoids unreliable Arabic-to-Latin transliteration for addresses.
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+9665' . fake()->unique()->numerify('########'),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'user_type' => 'customer',
            'avatar' => null,
            'is_active' => fake()->boolean(92),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['user_type' => 'admin', 'is_active' => true]);
    }

    public function customer(): static
    {
        return $this->state(fn () => ['user_type' => 'customer']);
    }

    public function serviceProviderUser(): static
    {
        return $this->state(fn () => ['user_type' => 'service_provider', 'is_active' => true]);
    }
}
