<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $providers = ServiceProvider::with('city')->withCount('properties')
            ->when($request->status, fn ($q, $v) => $q->where('verification_status', $v))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.providers.index', compact('providers'));
    }

    public function verify(ServiceProvider $serviceProvider)
    {
        $serviceProvider->update(['verification_status' => 'verified', 'verified_at' => now()]);

        return back()->with('status', __('admin.flash_provider_verified'));
    }

    public function reject(ServiceProvider $serviceProvider)
    {
        $serviceProvider->update(['verification_status' => 'rejected']);

        return back()->with('status', __('admin.flash_provider_rejected'));
    }
}
