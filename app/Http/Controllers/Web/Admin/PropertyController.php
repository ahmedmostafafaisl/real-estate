<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::with('city', 'serviceProvider')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->when($request->q, fn ($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function approve(Property $property)
    {
        $property->approve();

        return back()->with('status', __('admin.flash_property_approved'));
    }

    public function reject(Property $property, Request $request)
    {
        $data = $request->validate(['reason' => ['required', 'string', 'max:500']]);
        $property->reject($data['reason']);

        return back()->with('status', __('admin.flash_property_rejected'));
    }

    // Admin can moderate (delete) photos on any listing but cannot upload —
    // the content belongs to the provider; this is a moderation tool, not an editor.
    public function photos(Property $property)
    {
        $property->load('images');

        return view('admin.properties.photos', compact('property'));
    }

    public function destroyPhoto(Property $property, PropertyImage $image)
    {
        abort_unless($image->property_id === $property->id, 404);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('status', __('admin.flash_photo_removed'));
    }
}
