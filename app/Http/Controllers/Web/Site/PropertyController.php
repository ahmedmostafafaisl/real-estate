<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // Doubles as both "Property Search" (empty filters) and "Search Results" (filters applied).
    public function index(Request $request)
    {
        $properties = Property::with('city', 'type')
            ->where('status', 'published')
            ->when($request->q, fn ($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->city_id, fn ($q, $v) => $q->where('city_id', $v))
            ->when($request->property_type_id, fn ($q, $v) => $q->where('property_type_id', $v))
            ->when($request->listing_type, fn ($q, $v) => $q->where('listing_type', $v))
            ->when($request->min_price, fn ($q, $v) => $q->where('price', '>=', $v))
            ->when($request->max_price, fn ($q, $v) => $q->where('price', '<=', $v))
            ->when($request->bedrooms, fn ($q, $v) => $q->where('bedrooms', '>=', $v))
            ->when($request->get('sort') === 'price_asc', fn ($q) => $q->orderBy('price'))
            ->when($request->get('sort') === 'price_desc', fn ($q) => $q->orderByDesc('price'))
            ->when(! $request->get('sort'), fn ($q) => $q->latest())
            ->paginate(12)->withQueryString();

        $cities = City::orderBy('name')->get();
        $types = PropertyType::orderBy('name')->get();

        return view('site.properties.index', compact('properties', 'cities', 'types'));
    }

    public function show(Property $property)
    {
        abort_unless($property->status === 'published', 404);
        $property->increment('views_count');
        $property->load('city', 'district', 'category', 'type', 'images', 'features', 'serviceProvider');

        $similar = Property::where('status', 'published')->where('city_id', $property->city_id)
            ->where('id', '!=', $property->id)->limit(3)->get();

        return view('site.properties.show', compact('property', 'similar'));
    }

    public function storeInquiry(Property $property, Request $request)
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:1000']]);

        $property->inquiries()->create(['user_id' => $request->user()->id, 'message' => $data['message']]);

        return back()->with('status', 'Your message has been sent to the provider.');
    }

    public function storeViewingRequest(Property $property, Request $request)
    {
        $data = $request->validate(['requested_slot' => ['required', 'date', 'after:now']]);

        \App\Models\ViewingRequest::create([
            'property_id' => $property->id,
            'user_id' => $request->user()->id,
            'service_provider_id' => $property->service_provider_id,
            'requested_slot' => $data['requested_slot'],
        ]);

        return back()->with('status', 'Viewing requested — the provider will confirm a time with you.');
    }
}
