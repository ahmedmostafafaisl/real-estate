<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // event_key stays a stable English identifier (matched in application code);
        // only the human-facing label is Arabic.
        $events = [
            ['event_key' => 'inquiry.received', 'label' => 'استفسار جديد', 'push_enabled' => true, 'email_enabled' => true, 'whatsapp_enabled' => true],
            ['event_key' => 'viewing.confirmed', 'label' => 'تأكيد طلب معاينة', 'push_enabled' => true, 'email_enabled' => true, 'sms_enabled' => true, 'whatsapp_enabled' => true],
            ['event_key' => 'subscription.expiring', 'label' => 'اقتراب انتهاء الاشتراك', 'push_enabled' => true, 'email_enabled' => true],
            ['event_key' => 'property.approved', 'label' => 'تمت الموافقة على العقار', 'push_enabled' => true],
            ['event_key' => 'property.rejected', 'label' => 'تم رفض العقار', 'push_enabled' => true, 'email_enabled' => true],
            ['event_key' => 'property.expired', 'label' => 'انتهت صلاحية العقار', 'push_enabled' => true],
            ['event_key' => 'payment.received', 'label' => 'تم استلام الدفعة', 'email_enabled' => true],
        ];

        foreach ($events as $e) {
            NotificationTemplate::firstOrCreate(['event_key' => $e['event_key']], $e);
        }
    }
}
