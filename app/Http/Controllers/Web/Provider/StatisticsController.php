<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $provider = $request->user()->serviceProvider;

        $topProperties = $provider->properties()->orderByDesc('views_count')->limit(8)->get(['id', 'title', 'views_count']);
        $totalViews = $provider->properties()->sum('views_count');
        $avgViews = $provider->properties()->count() ? round($totalViews / $provider->properties()->count()) : 0;
        $totalInquiries = \App\Models\Inquiry::whereHas('property', fn ($q) => $q->where('service_provider_id', $provider->id))->count();
        $conversion = $totalViews ? round(($totalInquiries / $totalViews) * 100, 1) : 0;

        return view('provider.statistics', compact('topProperties', 'avgViews', 'conversion'));
    }
}
