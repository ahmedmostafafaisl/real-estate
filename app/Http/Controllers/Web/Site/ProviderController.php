<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $providers = ServiceProvider::with('city')->withCount(['properties' => fn ($q) => $q->where('status', 'published')])
            ->where('verification_status', 'verified')
            ->when($request->city_id, fn ($q, $v) => $q->where('city_id', $v))
            ->when($request->provider_type, fn ($q, $v) => $q->where('provider_type', $v))
            ->paginate(12)->withQueryString();

        $cities = City::orderBy('name')->get();

        return view('site.providers.index', compact('providers', 'cities'));
    }

    public function show(ServiceProvider $serviceProvider)
    {
        abort_unless($serviceProvider->verification_status === 'verified', 404);
        $serviceProvider->load('city');
        $properties = $serviceProvider->properties()->with('images')->where('status', 'published')->latest()->paginate(9);

        return view('site.providers.show', compact('serviceProvider', 'properties'));
    }
}
