<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        return NotificationTemplate::all();
    }

    public function update(Request $request, NotificationTemplate $notificationTemplate)
    {
        $notificationTemplate->update($request->validate([
            'push_enabled' => ['sometimes', 'boolean'],
            'email_enabled' => ['sometimes', 'boolean'],
            'sms_enabled' => ['sometimes', 'boolean'],
            'whatsapp_enabled' => ['sometimes', 'boolean'],
        ]));

        return $notificationTemplate;
    }
}
