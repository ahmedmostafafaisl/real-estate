<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Seeder;

class SubscriptionPackageSeeder extends Seeder
{
    public function run(): void
    {
        // slug is explicit (not derived from the Arabic name) since it's used
        // elsewhere as a stable identifier — e.g. highlighting the "Pro" tier.
        $packages = [
            ['slug' => 'basic', 'name' => 'أساسية', 'price' => 149, 'listing_limit' => 10, 'featured_listing_limit' => 0,
                'perks' => ['10 عقارات نشطة', 'دعم فني قياسي', 'تحليلات أساسية']],
            ['slug' => 'pro', 'name' => 'احترافية', 'price' => 399, 'listing_limit' => 40, 'featured_listing_limit' => 5,
                'perks' => ['40 عقاراً نشطاً', '5 فرص تمييز شهرياً', 'دعم فني ذو أولوية', 'تحليلات متقدمة']],
            ['slug' => 'enterprise', 'name' => 'مؤسسات', 'price' => 999, 'listing_limit' => 999, 'featured_listing_limit' => 25,
                'perks' => ['عقارات غير محدودة', '25 فرصة تمييز شهرياً', 'مدير حساب مخصص', 'وصول إلى واجهة API']],
        ];

        foreach ($packages as $p) {
            SubscriptionPackage::firstOrCreate(
                ['slug' => $p['slug']],
                [...$p, 'billing_cycle' => 'monthly']
            );
        }
    }
}
