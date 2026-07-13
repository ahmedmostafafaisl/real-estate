<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Payment;
use App\Models\Property;
use App\Models\ServiceProvider;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    // GET /api/admin/dashboard/stats
    public function stats()
    {
        return response()->json([
            'total_users' => User::where('user_type', 'customer')->count(),
            'total_service_providers' => ServiceProvider::count(),
            'pending_provider_approvals' => ServiceProvider::where('verification_status', 'pending')->count(),
            'total_properties' => Property::count(),
            'published_properties' => Property::where('status', 'published')->count(),
            'pending_properties' => Property::where('status', 'pending')->count(),
            'rejected_properties' => Property::where('status', 'rejected')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'expired_subscriptions' => Subscription::where('status', 'expired')->count(),
            'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
            'total_commissions' => Commission::sum('commission_amount'),
            'most_active_cities' => Property::selectRaw('city_id, count(*) as total')
                ->groupBy('city_id')->orderByDesc('total')->limit(5)
                ->with('city:id,name')->get(),
            'most_popular_property_types' => Property::selectRaw('property_type_id, count(*) as total')
                ->groupBy('property_type_id')->orderByDesc('total')->limit(5)
                ->with('type:id,name')->get(),
        ]);
    }
}
