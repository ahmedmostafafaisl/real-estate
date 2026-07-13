<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $provider = $request->user()->serviceProvider;

        $stats = [
            'total' => $provider->properties()->count(),
            'published' => $provider->properties()->where('status', 'published')->count(),
            'pending' => $provider->properties()->where('status', 'pending')->count(),
            'rejected' => $provider->properties()->where('status', 'rejected')->count(),
            'expired' => $provider->properties()->where('status', 'expired')->count(),
            'views' => $provider->properties()->sum('views_count'),
            'inquiries' => \App\Models\Inquiry::whereHas('property', fn ($q) => $q->where('service_provider_id', $provider->id))->count(),
            'viewing_requests' => \App\Models\ViewingRequest::where('service_provider_id', $provider->id)->count(),
            'revenue' => $provider->invoices()->where('status', 'paid')->sum('total'),
            'commissions' => $provider->commissions()->sum('commission_amount'),
        ];

        $subscription = $provider->activeSubscription()->with('package')->first();
        $daysLeft = $subscription ? now()->diffInDays($subscription->ends_at, false) : 0;

        $recentInquiries = \App\Models\Inquiry::whereHas('property', fn ($q) => $q->where('service_provider_id', $provider->id))
            ->with('property:id,title', 'user:id,name')->latest()->limit(5)->get();

        $upcomingViewings = \App\Models\ViewingRequest::where('service_provider_id', $provider->id)
            ->with('property:id,title', 'user:id,name')->orderBy('requested_slot')->limit(5)->get();

        return view('provider.dashboard', compact('stats', 'subscription', 'daysLeft', 'recentInquiries', 'upcomingViewings'));
    }
}
