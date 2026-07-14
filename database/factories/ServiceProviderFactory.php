<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceProviderFactory extends Factory
{
    protected $model = ServiceProvider::class;

    protected static array $officeWords = [
        'النخيل', 'الأفق', 'دار البناء', 'الساحل', 'الصقر', 'زهرة الشرق', 'الاتحاد', 'طريق الحرير',
        'الواحة', 'المفتاح المشرق', 'سبيل', 'المشارق', 'نورس', 'الكثبان', 'الريف', 'الأرز',
        'القصر', 'اليمامة', 'الأفق الذهبي', 'البساتين', 'الرؤية', 'المجد', 'الديار', 'سنابل',
    ];
    protected static array $officeSuffixes = [
        'العقارية', 'للعقارات', 'للتطوير العقاري', 'القابضة', 'للإسكان', 'العقارات المتحدة', 'الاستثمارية',
    ];
    protected static array $bioTemplates = [
        'مكتب عقاري متكامل يقدم خدمات البيع والإيجار السكني والتجاري في :city وما حولها منذ عدة سنوات.',
        'فريق متخصص في الوساطة العقارية، يركز على تقديم تجربة سلسة وشفافة للعملاء في :city.',
        'شركة تطوير عقاري تعمل على مشاريع سكنية وتجارية مميزة في :city، بخبرة تمتد لأكثر من عقد.',
        'وسيط عقاري معتمد يساعد الأفراد والشركات على إيجاد العقار المناسب في :city بأفضل الشروط.',
    ];

    public function definition(): array
    {
        $city = City::inRandomOrder()->first();
        $cityName = $city->name ?? 'المدينة';

        return [
            'user_id' => User::factory()->serviceProviderUser(),
            'office_name' => fake()->randomElement(self::$officeWords) . ' ' . fake()->randomElement(self::$officeSuffixes),
            'provider_type' => fake()->randomElement(['agency', 'broker', 'owner', 'developer']),
            'commercial_register_no' => fake()->boolean(80) ? fake()->numerify('##########') : null,
            'license_no' => fake()->boolean(70) ? 'LIC-' . fake()->numerify('#####') : null,
            'city_id' => $city->id ?? City::factory(),
            'address' => 'شارع ' . fake()->randomElement(['الملك فهد', 'الملك عبدالعزيز', 'الأمير سلطان', 'العروبة', 'التحلية']) . '، ' . $cityName,
            'logo' => null,
            'bio' => fake()->boolean(75) ? str_replace(':city', $cityName, fake()->randomElement(self::$bioTemplates)) : null,
            'verification_status' => fake()->randomElement(['pending', 'verified', 'verified', 'verified', 'rejected']),
            'verified_at' => null,
            'commission_rate' => fake()->randomElement([1.5, 2.0, 2.0, 2.5, 3.0]),
            'notification_preferences' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (ServiceProvider $provider) {
            if ($provider->verification_status === 'verified' && ! $provider->verified_at) {
                $provider->verified_at = fake()->dateTimeBetween('-1 year', 'now');
            }
        });
    }

    public function verified(): static
    {
        return $this->state(fn () => ['verification_status' => 'verified', 'verified_at' => fake()->dateTimeBetween('-1 year', 'now')]);
    }

    public function pending(): static
    {
        return $this->state(fn () => ['verification_status' => 'pending', 'verified_at' => null]);
    }
}
