<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $provider = $request->user()->serviceProvider;

        $properties = $provider->properties()
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->when($request->q, fn ($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->latest()->paginate(15)->withQueryString();

        return view('provider.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('provider.properties.form', [
            'property' => new Property(),
            'categories' => PropertyCategory::with('types')->get(),
            'cities' => City::all(),
            'features' => PropertyFeature::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_category_id' => ['required', 'exists:property_categories,id'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'listing_type' => ['required', 'in:sale,rent'],
            'price' => ['required', 'numeric', 'min:0'],
            'area_sqm' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'array'],
        ]);

        $provider = $request->user()->serviceProvider;
        $submit = $request->boolean('submit_for_review');

        $property = $provider->properties()->create([
            ...$data,
            'slug' => Str::slug($data['title']) . '-' . Str::random(6),
            'status' => $submit ? 'pending' : 'draft',
        ]);

        if (! empty($data['features'])) {
            $property->features()->sync($data['features']);
        }

        return redirect()->route('provider.properties.index')->with('status', 'Listing created.');
    }

    public function edit(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);

        return view('provider.properties.form', [
            'property' => $property->load('features'),
            'categories' => PropertyCategory::with('types')->get(),
            'cities' => City::all(),
            'features' => PropertyFeature::all(),
        ]);
    }

    public function update(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'area_sqm' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'city_id' => ['required', 'exists:cities,id'],
            'features' => ['nullable', 'array'],
        ]);

        $property->update($data);
        $property->features()->sync($data['features'] ?? []);

        return redirect()->route('provider.properties.index')->with('status', 'Listing updated.');
    }

    public function destroy(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $property->delete();

        return redirect()->route('provider.properties.index')->with('status', 'Listing deleted.');
    }

    public function submit(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $property->submitForReview();

        return back()->with('status', 'Submitted for review.');
    }

    public function pause(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $property->update(['status' => 'draft']);

        return back()->with('status', 'Listing paused.');
    }

    public function closeDeal(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $data = $request->validate(['deal_type' => ['required', 'in:sold,rented']]);

        $property->update(['status' => $data['deal_type']]);
        \App\Models\Commission::generateFor($property);

        return back()->with('status', 'Deal recorded and commission generated.');
    }
}
