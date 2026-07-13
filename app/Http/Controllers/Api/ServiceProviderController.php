<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceProviderResource;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    // GET /api/providers — public directory
    public function index(Request $request)
    {
        $providers = ServiceProvider::with('city')
            ->withCount('properties')
            ->where('verification_status', 'verified')
            ->when($request->city_id, fn ($q, $v) => $q->where('city_id', $v))
            ->when($request->provider_type, fn ($q, $v) => $q->where('provider_type', $v))
            ->paginate(15);

        return ServiceProviderResource::collection($providers);
    }

    public function show(ServiceProvider $serviceProvider)
    {
        $serviceProvider->load(['city', 'activeSubscription.package'])->loadCount('properties');
        return new ServiceProviderResource($serviceProvider);
    }

    // PATCH /api/provider/profile — self-service update
    public function updateProfile(Request $request)
    {
        $provider = $request->user()->serviceProvider;
        abort_unless($provider, 404);

        $provider->update($request->validate([
            'office_name' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string'],
            'bio' => ['sometimes', 'nullable', 'string'],
            'logo' => ['sometimes', 'nullable', 'string'],
        ]));

        return new ServiceProviderResource($provider);
    }

    // GET /api/provider/dashboard — provider's own dashboard stats
    public function dashboard(Request $request)
    {
        $provider = $request->user()->serviceProvider;
        abort_unless($provider, 404);

        return response()->json([
            'total_properties' => $provider->properties()->count(),
            'published_properties' => $provider->properties()->where('status', 'published')->count(),
            'pending_properties' => $provider->properties()->where('status', 'pending')->count(),
            'rejected_properties' => $provider->properties()->where('status', 'rejected')->count(),
            'expired_properties' => $provider->properties()->where('status', 'expired')->count(),
            'total_views' => $provider->properties()->sum('views_count'),
            'active_subscription' => $provider->activeSubscription?->load('package'),
            'revenue_summary' => $provider->invoices()->where('status', 'paid')->sum('total'),
            'commission_summary' => $provider->commissions()->sum('commission_amount'),
        ]);
    }
}
