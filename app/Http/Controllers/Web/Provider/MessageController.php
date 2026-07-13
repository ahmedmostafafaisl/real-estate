<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Threads are inquiries-turned-conversations. A dedicated messages table/broadcast
    // channel is the natural next step; for now this surfaces inquiries as threads.
    public function index(Request $request)
    {
        $providerId = $request->user()->serviceProvider->id;

        $threads = \App\Models\Inquiry::whereHas('property', fn ($q) => $q->where('service_provider_id', $providerId))
            ->with('property:id,title', 'user:id,name')
            ->latest()->limit(20)->get();

        return view('provider.messages', compact('threads'));
    }
}
