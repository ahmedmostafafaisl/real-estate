<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Commission;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertyFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'property' => new Property,
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
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        $provider = $request->user()->serviceProvider;
        $submit = $request->boolean('submit_for_review');

        $property = $provider->properties()->create([
            ...collect($data)->except(['photos'])->all(),
            'slug' => Str::slug($data['title'], '-', 'en') ?: 'property',
            'status' => $submit ? 'pending' : 'draft',
        ]);
        // Same reasoning as the seeder factory: Str::slug() can't reliably transliterate
        // Arabic titles, so always append a random suffix to guarantee uniqueness.
        $property->update(['slug' => trim($property->slug.'-'.Str::lower(Str::random(6)), '-')]);

        if (! empty($data['features'])) {
            $property->features()->sync($data['features']);
        }

        $this->storeUploadedPhotos($property, $request->file('photos', []));

        return redirect()->route('provider.properties.index')->with('status', __('provider.flash_listing_created'));
    }

    public function edit(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);

        return view('provider.properties.form', [
            'property' => $property->load('features', 'images'),
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
            'photos' => ['nullable', 'array', 'max:10'],
            'photos.*' => ['image', 'max:5120'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:property_images,id'],
            'featured_image_id' => ['nullable', 'integer', 'exists:property_images,id'],
        ]);

        $property->update(collect($data)->except(['photos', 'delete_images', 'featured_image_id'])->all());
        $property->features()->sync($data['features'] ?? []);

        if (! empty($data['delete_images'])) {
            $property->images()->whereIn('id', $data['delete_images'])->get()->each(function ($image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            });
        }

        $this->storeUploadedPhotos($property, $request->file('photos', []));

        if (! empty($data['featured_image_id'])) {
            $property->images()->update(['is_featured' => false]);
            $property->images()->where('id', $data['featured_image_id'])->update(['is_featured' => true]);
        }

        return redirect()->route('provider.properties.index')->with('status', __('provider.flash_listing_updated'));
    }

    // Shared by store() and update() — saves uploaded files to the public disk and
    // creates the matching property_images rows, continuing the sort order and
    // making the very first photo on a brand-new listing the featured one.
    protected function storeUploadedPhotos(Property $property, array $files): void
    {
        if (empty($files)) {
            return;
        }

        $nextOrder = (int) $property->images()->max('sort_order');
        $hasFeatured = $property->images()->where('is_featured', true)->exists();

        foreach ($files as $i => $file) {
            $path = $file->store("properties/{$property->id}", 'public');

            $property->images()->create([
                'path' => $path,
                'type' => 'image',
                'sort_order' => ++$nextOrder,
                'is_featured' => ! $hasFeatured && $i === 0,
            ]);
        }
    }

    public function destroy(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $property->delete();

        return redirect()->route('provider.properties.index')->with('status', __('provider.flash_listing_deleted'));
    }

    public function submit(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $property->submitForReview();

        return back()->with('status', __('provider.flash_submitted_review'));
    }

    public function pause(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $property->update(['status' => 'draft']);

        return back()->with('status', __('provider.flash_listing_paused'));
    }

    public function closeDeal(Property $property, Request $request)
    {
        abort_unless($property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $data = $request->validate(['deal_type' => ['required', 'in:sold,rented']]);

        $property->update(['status' => $data['deal_type']]);
        Commission::generateFor($property);

        return back()->with('status', __('provider.flash_deal_recorded'));
    }
}
