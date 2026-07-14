<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // GET /api/favorites
    public function index(Request $request)
    {
        $favorites = $request->user()->favorites()
            ->with(['city', 'district', 'category', 'type', 'images'])
            ->latest('favorites.created_at')
            ->paginate(15);

        return PropertyResource::collection($favorites);
    }

    // POST /api/properties/{property}/favorite — toggles on/off, returns the new state
    public function toggle(Property $property, Request $request)
    {
        $user = $request->user();
        $exists = $user->favorites()->where('property_id', $property->id)->exists();

        if ($exists) {
            $user->favorites()->detach($property->id);
            return response()->json(['favorited' => false]);
        }

        $user->favorites()->attach($property->id);
        return response()->json(['favorited' => true]);
    }
}
