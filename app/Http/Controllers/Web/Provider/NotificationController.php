<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $provider = $request->user()->serviceProvider;
        $templates = NotificationTemplate::all();
        $overrides = $provider->notification_preferences ?? [];

        return view('provider.notifications', compact('templates', 'overrides'));
    }

    public function update(Request $request)
    {
        $provider = $request->user()->serviceProvider;
        $data = $request->validate(['preferences' => ['required', 'array']]);

        $provider->update(['notification_preferences' => $data['preferences']]);

        return back()->with('status', 'Notification preferences saved.');
    }
}
