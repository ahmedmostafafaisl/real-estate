<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
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

    public function show(Property $property)
    {
        $property->load('images', 'features', 'category', 'type', 'city', 'district', 'serviceProvider.city');

        $reviews = $property->reviews()->with('user:id,name')->latest()->limit(5)->get();
        $reports = $property->reports()->with('user:id,name')->latest()->limit(5)->get();
        $stats = [
            'inquiries' => $property->inquiries()->count(),
            'viewing_requests' => $property->viewingRequests()->count(),
        ];

        return view('admin.properties.show', compact('property', 'reviews', 'reports', 'stats'));
    }

    public function approve(Property $property)
    {
        $property->approve();
        $this->notifyOwner($property, 'property.approved', 'Listing approved', "\"{$property->title}\" is now live.");

        return back()->with('status', __('admin.flash_property_approved'));
    }

    public function reject(Property $property, Request $request)
    {
        $data = $request->validate(['reason' => ['required', 'string', 'max:500']]);
        $property->reject($data['reason']);
        $this->notifyOwner($property, 'property.rejected', 'Listing rejected', $data['reason']);

        return back()->with('status', __('admin.flash_property_rejected'));
    }

    protected function notifyOwner(Property $property, string $eventKey, string $title, string $body): void
    {
        $user = $property->serviceProvider->user ?? null;
        if ($user) {
            SendNotificationJob::dispatch($user->id, $eventKey, $title, $body, ['property_id' => $property->id]);
        }
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
