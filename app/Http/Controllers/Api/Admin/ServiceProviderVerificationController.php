<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceProviderResource;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderVerificationController extends Controller
{
    public function pending()
    {
        $providers = ServiceProvider::with(['city', 'documents'])
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(15);

        return ServiceProviderResource::collection($providers);
    }

    public function verify(ServiceProvider $serviceProvider)
    {
        $serviceProvider->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
        ]);

        return new ServiceProviderResource($serviceProvider);
    }

    public function reject(ServiceProvider $serviceProvider, Request $request)
    {
        $request->validate(['reason' => ['required', 'string']]);
        $serviceProvider->update(['verification_status' => 'rejected']);

        return new ServiceProviderResource($serviceProvider);
    }
}
