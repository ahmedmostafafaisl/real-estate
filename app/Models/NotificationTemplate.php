<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = [
        'event_key', 'label', 'push_enabled', 'email_enabled',
        'sms_enabled', 'whatsapp_enabled',
    ];

    protected function casts(): array
    {
        return [
            'push_enabled' => 'boolean', 'email_enabled' => 'boolean',
            'sms_enabled' => 'boolean', 'whatsapp_enabled' => 'boolean',
        ];
    }
}
