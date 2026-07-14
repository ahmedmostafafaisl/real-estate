<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    protected static array $adjectives = ['عصرية', 'واسعة', 'مريحة', 'فاخرة', 'حديثة التجديد', 'أنيقة', 'جذابة', 'معاصرة'];

    protected static array $descTemplates = [
        ':adj تقع في موقع مميز في :city، قريبة من الخدمات الأساسية والمرافق العامة. تتميز بتشطيبات عالية الجودة وتصميم عملي يناسب احتياجات السكن أو العمل.',
        'وحدة :adj في :city ضمن مجمع هادئ، مع سهولة الوصول إلى الطرق الرئيسية والمدارس والأسواق. مناسبة للعائلات الباحثة عن الراحة والخصوصية.',
        'فرصة استثمارية في :city — عقار :adj بتشطيب ممتاز وإطلالة جيدة، ضمن منطقة تشهد نمواً عمرانياً متسارعاً.',
        'عقار :adj حديث البناء في :city، يضم مساحات واسعة وإضاءة طبيعية جيدة، ويقع على شارع رئيسي.',
    ];

    public function definition(): array
    {
        $type = PropertyType::inRandomOrder()->first();
        $city = City::inRandomOrder()->first();
        $district = $city ? $city->districts()->inRandomOrder()->first() : null;
        $cityName = $city->name ?? 'المدينة';
        $adjective = fake()->randomElement(self::$adjectives);

        $bedrooms = fake()->boolean(80) ? fake()->numberBetween(1, 6) : null;
        $title = trim(($type->name ?? 'عقار').' '.$adjective.
            ($bedrooms ? " - {$bedrooms} غرف" : '').' في '.$cityName);

        $status = fake()->randomElement([
            'draft', 'pending', 'published', 'published', 'published', 'published',
            'sold', 'rented', 'expired', 'rejected',
        ]);

        $description = str_replace(
            [':adj', ':city'],
            [$adjective, $cityName],
            fake()->randomElement(self::$descTemplates)
        );

        return [
            'service_provider_id' => ServiceProvider::factory(),
            'property_category_id' => $type->property_category_id ?? 1,
            'property_type_id' => $type->id ?? 1,
            'city_id' => $city->id ?? 1,
            'district_id' => $district?->id,
            'title' => $title,
            'slug' => trim((Str::slug($title, '-', 'en') ?: 'property').'-'.Str::lower(Str::random(6)), '-'),
            'description' => $description,
            'listing_type' => fake()->randomElement(['sale', 'rent']),
            'price' => fake()->numberBetween(150, 2500) * 1000,
            'area_sqm' => fake()->numberBetween(60, 650),
            'bedrooms' => $bedrooms,
            'bathrooms' => $bedrooms ? min($bedrooms, fake()->numberBetween(1, 5)) : null,
            'dynamic_attributes' => null,
            'latitude' => fake()->latitude(16, 32),
            'longitude' => fake()->longitude(34, 50),
            'status' => $status,
            'rejection_reason' => $status === 'rejected' ? fake()->randomElement([
                'الصور المرفقة لا تطابق الوصف المكتوب.', 'السعر المدرج غير متوافق مع أسعار السوق الحالية.',
                'المستندات التجارية المطلوبة غير مكتملة.',
            ]) : null,
            'is_featured' => fake()->boolean(15),
            'published_at' => in_array($status, ['published', 'sold', 'rented', 'expired']) ? fake()->dateTimeBetween('-6 months', 'now') : null,
            'expires_at' => $status === 'expired' ? fake()->dateTimeBetween('-2 months', '-1 day') : ($status === 'published' ? fake()->dateTimeBetween('+1 week', '+6 months') : null),
            'views_count' => fake()->numberBetween(0, 4500),
            'created_at' => fake()->dateTimeBetween('-8 months', 'now'),
        ];
    }
}
