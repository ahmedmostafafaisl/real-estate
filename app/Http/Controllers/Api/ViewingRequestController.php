<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\ViewingRequest;
use Illuminate\Http\Request;

class ViewingRequestController extends Controller
{
    public function store(Property $property, Request $request)
    {
        $data = $request->validate(['requested_slot' => ['required', 'date', 'after:now']]);

        $viewing = ViewingRequest::create([
            'property_id' => $property->id,
            'user_id' => $request->user()->id,
            'service_provider_id' => $property->service_provider_id,
            'requested_slot' => $data['requested_slot'],
        ]);

        return response()->json($viewing, 201);
    }

    public function index(Request $request)
    {
        $query = ViewingRequest::with('property:id,title', 'user:id,name');

        if ($request->user()->user_type === 'service_provider') {
            $query->where('service_provider_id', $request->user()->serviceProvider->id);
        } else {
            $query->where('user_id', $request->user()->id);
        }

        return $query->latest()->paginate(15);
    }

    public function updateStatus(ViewingRequest $viewingRequest, Request $request)
    {
        $data = $request->validate(['status' => ['required', 'in:confirmed,completed,cancelled']]);
        $viewingRequest->update(['status' => $data['status']]);
        return $viewingRequest;
    }
}
