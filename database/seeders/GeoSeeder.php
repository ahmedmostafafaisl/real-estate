<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Region;
use Illuminate\Database\Seeder;

class GeoSeeder extends Seeder
{
    protected array $knownDistricts = [
        'الرياض' => ['العليا', 'الملقا', 'النرجس', 'الياسمين', 'الروضة', 'السليمانية', 'حطين'],
        'جدة' => ['الشاطئ', 'الروضة', 'الزهراء', 'السلامة', 'الحمراء', 'أبحر الشمالية'],
        'الدمام' => ['الشاطئ', 'الفيصلية', 'الجلوية', 'النخيل', 'الأنوار'],
        'مكة المكرمة' => ['العزيزية', 'الششة', 'النسيم', 'الزاهر'],
        'المدينة المنورة' => ['قباء', 'العوالي', 'الحرة الشرقية', 'الدفاع'],
        'الخبر' => ['العقربية', 'الثقبة', 'الراكة', 'اليرموك'],
    ];
    protected array $genericDistricts = ['حي الشمال', 'حي الجنوب', 'حي الشرق', 'حي الغرب', 'حي الوسط'];

    public function run(): void
    {
        $sa = Country::firstOrCreate(['code' => 'SAU'], ['name' => 'المملكة العربية السعودية']);

        $regions = [
            'منطقة الرياض' => ['الرياض', 'الخرج', 'الدرعية'],
            'منطقة مكة المكرمة' => ['جدة', 'مكة المكرمة', 'الطائف'],
            'المنطقة الشرقية' => ['الدمام', 'الخبر', 'الظهران', 'الأحساء'],
            'منطقة المدينة المنورة' => ['المدينة المنورة', 'ينبع'],
            'منطقة عسير' => ['أبها', 'خميس مشيط'],
            'منطقة القصيم' => ['بريدة', 'عنيزة'],
        ];

        foreach ($regions as $regionName => $cities) {
            $region = Region::firstOrCreate(['country_id' => $sa->id, 'name' => $regionName]);
            foreach ($cities as $cityName) {
                $city = City::firstOrCreate(['region_id' => $region->id, 'name' => $cityName]);

                $districts = $this->knownDistricts[$cityName] ?? $this->genericDistricts;
                foreach ($districts as $districtName) {
                    District::firstOrCreate(['city_id' => $city->id, 'name' => $districtName]);
                }
            }
        }
    }
}
