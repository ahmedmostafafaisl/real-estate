<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Payment;
use App\Models\Property;
use App\Models\ServiceProvider;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('user_type', 'customer')->count(),
            'total_providers' => ServiceProvider::count(),
            'pending_providers' => ServiceProvider::where('verification_status', 'pending')->count(),
            'total_properties' => Property::count(),
            'published_properties' => Property::where('status', 'published')->count(),
            'pending_properties' => Property::where('status', 'pending')->count(),
            'rejected_properties' => Property::where('status', 'rejected')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'expired_subscriptions' => Subscription::where('status', 'expired')->count(),
            'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
            'total_commissions' => Commission::sum('commission_amount'),
        ];

        $activeCities = Property::selectRaw('city_id, count(*) as total')
            ->groupBy('city_id')->orderByDesc('total')->limit(5)->with('city:id,name')->get();

        $popularTypes = Property::selectRaw('property_type_id, count(*) as total')
            ->groupBy('property_type_id')->orderByDesc('total')->limit(5)->with('type:id,name')->get();

        $pendingApprovals = Property::where('status', 'pending')->with('serviceProvider:id,office_name')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'activeCities', 'popularTypes', 'pendingApprovals'));
    }
}
