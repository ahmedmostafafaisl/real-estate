<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Property $property, Request $request)
    {
        $data = $request->validate(['message' => ['required', 'string', 'max:1000']]);

        $inquiry = $property->inquiries()->create([
            'user_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        return response()->json($inquiry, 201);
    }

    // GET /api/provider/inquiries
    public function index(Request $request)
    {
        $providerId = $request->user()->serviceProvider->id;

        return \App\Models\Inquiry::whereHas('property', fn ($q) => $q->where('service_provider_id', $providerId))
            ->with('property:id,title', 'user:id,name')
            ->latest()->paginate(15);
    }

    public function respond(\App\Models\Inquiry $inquiry)
    {
        $inquiry->update(['status' => 'responded']);
        return $inquiry;
    }
}
