<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RejectPropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyApprovalController extends Controller
{
    // GET /api/admin/properties/pending
    public function pending()
    {
        $properties = Property::with(['city', 'category', 'type', 'serviceProvider'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return PropertyResource::collection($properties);
    }

    // POST /api/admin/properties/{property}/approve
    public function approve(Property $property)
    {
        $property->approve();
        return new PropertyResource($property);
    }

    // POST /api/admin/properties/{property}/reject
    public function reject(RejectPropertyRequest $request, Property $property)
    {
        $property->reject($request->validated('reason'));
        return new PropertyResource($property);
    }
}
