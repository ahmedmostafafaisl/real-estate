<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('user_type', 'customer')->pluck('id');
        $propertyIds = Property::where('status', 'published')->pluck('id');

        if ($customers->isEmpty() || $propertyIds->isEmpty()) {
            $this->command?->warn('Skipping FavoriteSeeder: seed customers and published properties first.');
            return;
        }

        $rows = [];
        $seenPairs = [];
        $target = 1500;

        while (count($rows) < $target) {
            $userId = $customers->random();
            $propertyId = $propertyIds->random();
            $key = "{$userId}-{$propertyId}";

            if (isset($seenPairs[$key])) {
                continue;
            }
            $seenPairs[$key] = true;

            $rows[] = [
                'user_id' => $userId,
                'property_id' => $propertyId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            \Illuminate\Support\Facades\DB::table('favorites')->insert($chunk);
        }
    }
}
