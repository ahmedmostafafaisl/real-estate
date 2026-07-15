<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        // Capped at the actual number of possible unique pairs — without this,
        // a smaller dataset (fewer customers or published properties than the
        // fixed target) makes the while loop below unable to ever reach
        // $target, since every combination is already used. Only matters below
        // full production scale (600 customers × ~1,200 properties trivially
        // clears 1500), but a seeder should be correct at any scale, not just
        // the one it happens to usually run at.
        $target = min(1500, $customers->count() * $propertyIds->count());

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
            DB::table('favorites')->insert($chunk);
        }
    }
}
