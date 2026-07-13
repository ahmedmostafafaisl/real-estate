<?php

namespace Database\Seeders;

use App\Models\PropertyCategory;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyTaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $taxonomy = [
            'Residential' => ['Apartment', 'Villa', 'Townhouse'],
            'Commercial' => ['Office', 'Retail'],
            'Land' => ['Land Plot'],
            'Industrial' => ['Warehouse'],
        ];

        foreach ($taxonomy as $categoryName => $types) {
            $category = PropertyCategory::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            foreach ($types as $typeName) {
                PropertyType::firstOrCreate(
                    ['slug' => Str::slug($typeName)],
                    ['property_category_id' => $category->id, 'name' => $typeName]
                );
            }
        }

        foreach (['Parking', 'Swimming Pool', 'Elevator', 'Central AC', 'Balcony', 'Maid Room', 'Security', 'Garden'] as $feature) {
            PropertyFeature::firstOrCreate(['name' => $feature]);
        }
    }
}
