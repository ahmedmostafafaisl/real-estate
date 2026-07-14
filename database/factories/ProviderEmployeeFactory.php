<?php

namespace Database\Factories;

use App\Models\ProviderEmployee;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderEmployeeFactory extends Factory
{
    protected $model = ProviderEmployee::class;

    protected static array $maleFirst = ['محمد', 'أحمد', 'عبدالرحمن', 'يزيد', 'راشد', 'مشعل', 'عبدالعزيز', 'صالح'];
    protected static array $femaleFirst = ['هيا', 'جواهر', 'ندى', 'روان', 'أروى', 'دلال', 'العنود', 'سلمى'];
    protected static array $family = ['المالكي', 'الفهد', 'العمري', 'الزهراني', 'القحطاني', 'الحارثي', 'اليامي'];
    protected static array $jobTitles = ['مندوب مبيعات', 'منسق مكتب', 'مستشار تأجير', 'مسؤول تسويق', 'مدير العمليات'];

    public function definition(): array
    {
        $isMale = fake()->boolean();
        $name = fake()->randomElement($isMale ? self::$maleFirst : self::$femaleFirst) . ' ' . fake()->randomElement(self::$family);

        return [
            'service_provider_id' => ServiceProvider::factory(),
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+9665' . fake()->unique()->numerify('########'),
            'job_title' => fake()->randomElement(self::$jobTitles),
            'is_active' => fake()->boolean(85),
        ];
    }
}
