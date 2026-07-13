<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'platform_name' => 'Keystone',
            'currency' => 'SAR',
            'tax_rate' => '15',
            'commission_rate' => '2.0',
            'support_email' => 'support@keystone.io',
            'maps_key' => '',
            'fcm_key' => '',
            'payment_key' => '',
        ];

        foreach ($defaults as $key => $value) {
            SystemSetting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
