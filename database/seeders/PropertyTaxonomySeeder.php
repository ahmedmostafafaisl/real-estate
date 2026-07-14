<?php

namespace Database\Seeders;

use App\Models\PropertyCategory;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTaxonomySeeder extends Seeder
{
    public function run(): void
    {
        // Slugs are kept as stable Latin identifiers — Str::slug() can't transliterate
        // Arabic, and nothing in the app routes by these slugs, so they just need to
        // stay unique and stable while the display name is Arabic.
        $taxonomy = [
            ['name' => 'سكني', 'slug' => 'residential', 'types' => [
                ['name' => 'شقة', 'slug' => 'apartment'],
                ['name' => 'فيلا', 'slug' => 'villa'],
                ['name' => 'تاون هاوس', 'slug' => 'townhouse'],
            ]],
            ['name' => 'تجاري', 'slug' => 'commercial', 'types' => [
                ['name' => 'مكتب', 'slug' => 'office'],
                ['name' => 'محل تجاري', 'slug' => 'retail'],
            ]],
            ['name' => 'أراضٍ', 'slug' => 'land', 'types' => [
                ['name' => 'أرض', 'slug' => 'land-plot'],
            ]],
            ['name' => 'صناعي', 'slug' => 'industrial', 'types' => [
                ['name' => 'مستودع', 'slug' => 'warehouse'],
            ]],
        ];

        foreach ($taxonomy as $cat) {
            $category = PropertyCategory::firstOrCreate(['slug' => $cat['slug']], ['name' => $cat['name']]);

            foreach ($cat['types'] as $type) {
                PropertyType::firstOrCreate(
                    ['slug' => $type['slug']],
                    ['property_category_id' => $category->id, 'name' => $type['name']]
                );
            }
        }

        $features = [
            'موقف سيارات', 'مسبح', 'مصعد', 'تكييف مركزي', 'شرفة',
            'غرفة خادمة', 'حراسة أمنية', 'حديقة', 'نظام لاسلكي ذكي', 'مطبخ مجهز',
            'غرفة غسيل', 'مصعد خدمة', 'نظام إنذار', 'كاميرات مراقبة', 'عزل حراري',
        ];

        foreach ($features as $feature) {
            PropertyFeature::firstOrCreate(['name' => $feature]);
        }
    }
}
