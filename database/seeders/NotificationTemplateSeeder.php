<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            ['event_key' => 'inquiry.received', 'label' => 'New inquiry received', 'push_enabled' => true, 'email_enabled' => true, 'whatsapp_enabled' => true],
            ['event_key' => 'viewing.confirmed', 'label' => 'Viewing request confirmed', 'push_enabled' => true, 'email_enabled' => true, 'sms_enabled' => true, 'whatsapp_enabled' => true],
            ['event_key' => 'subscription.expiring', 'label' => 'Subscription expiring soon', 'push_enabled' => true, 'email_enabled' => true],
            ['event_key' => 'property.approved', 'label' => 'Property approved', 'push_enabled' => true],
            ['event_key' => 'property.rejected', 'label' => 'Property rejected', 'push_enabled' => true, 'email_enabled' => true],
            ['event_key' => 'payment.received', 'label' => 'Payment received', 'email_enabled' => true],
        ];

        foreach ($events as $e) {
            NotificationTemplate::firstOrCreate(['event_key' => $e['event_key']], $e);
        }
    }
}
