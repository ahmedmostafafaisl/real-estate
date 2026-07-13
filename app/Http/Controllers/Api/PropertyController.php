<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    // GET /api/properties — public search & browse
    public function index(Request $request)
    {
        $query = Property::query()
            ->with(['city', 'district', 'category', 'type', 'images', 'features'])
            ->where('status', 'published');

        $query->when($request->city_id, fn ($q, $v) => $q->where('city_id', $v));
        $query->when($request->district_id, fn ($q, $v) => $q->where('district_id', $v));
        $query->when($request->property_type_id, fn ($q, $v) => $q->where('property_type_id', $v));
        $query->when($request->listing_type, fn ($q, $v) => $q->where('listing_type', $v));
        $query->when($request->min_price, fn ($q, $v) => $q->where('price', '>=', $v));
        $query->when($request->max_price, fn ($q, $v) => $q->where('price', '<=', $v));
        $query->when($request->bedrooms, fn ($q, $v) => $q->where('bedrooms', '>=', $v));
        $query->when($request->boolean('featured_only'), fn ($q) => $q->where('is_featured', true));

        $query->when($request->q, fn ($q, $v) => $q->where('title', 'like', "%{$v}%"));

        match ($request->get('sort', 'newest')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular' => $query->orderByDesc('views_count'),
            default => $query->latest(),
        };

        return PropertyResource::collection($query->paginate($request->get('per_page', 15)));
    }

    public function show(Property $property)
    {
        abort_unless($property->status === 'published' || optional(request()->user())->can('view-any-property'), 404);

        $property->increment('views_count');
        $property->load(['city', 'district', 'category', 'type', 'images', 'features', 'serviceProvider']);

        return new PropertyResource($property);
    }

    // POST /api/provider/properties — provider creates a draft listing
    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();
        $provider = $request->user()->serviceProvider;

        abort_unless($provider->activeSubscription, 403, 'An active subscription is required to create listings.');

        $property = $provider->properties()->create([
            ...$data,
            'slug' => Str::slug($data['title']) . '-' . Str::random(6),
            'status' => 'draft',
        ]);

        if (! empty($data['features'])) {
            $property->features()->sync($data['features']);
        }

        return new PropertyResource($property->load(['city', 'district', 'category', 'type', 'features']));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();
        $property->update($data);

        if (array_key_exists('features', $data)) {
            $property->features()->sync($data['features']);
        }

        return new PropertyResource($property->fresh(['city', 'district', 'category', 'type', 'features']));
    }

    public function destroy(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider?->id, 403);
        $property->delete();
        return response()->json(['message' => 'Property deleted']);
    }

    // POST /api/provider/properties/{property}/submit
    public function submit(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider?->id, 403);
        $property->submitForReview();
        return new PropertyResource($property);
    }

    // POST /api/provider/properties/{property}/pause
    public function pause(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider?->id, 403);
        $property->update(['status' => 'draft']);
        return new PropertyResource($property);
    }

    // POST /api/provider/properties/{property}/mark-sold  (or mark-rented)
    public function markDealClosed(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider?->id, 403);
        $request->validate(['deal_type' => ['required', 'in:sold,rented']]);

        $property->update(['status' => $request->deal_type]);

        \App\Models\Commission::generateFor($property);

        return new PropertyResource($property);
    }
}
