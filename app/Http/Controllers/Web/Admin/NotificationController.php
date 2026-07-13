<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $templates = NotificationTemplate::all();
        return view('admin.notifications', compact('templates'));
    }

    public function update(NotificationTemplate $notificationTemplate, Request $request)
    {
        $data = $request->validate([
            'push_enabled' => ['nullable', 'boolean'],
            'email_enabled' => ['nullable', 'boolean'],
            'sms_enabled' => ['nullable', 'boolean'],
            'whatsapp_enabled' => ['nullable', 'boolean'],
        ]);

        $notificationTemplate->update([
            'push_enabled' => $request->boolean('push_enabled'),
            'email_enabled' => $request->boolean('email_enabled'),
            'sms_enabled' => $request->boolean('sms_enabled'),
            'whatsapp_enabled' => $request->boolean('whatsapp_enabled'),
        ]);

        return back()->with('status', 'Notification template updated.');
    }
}
