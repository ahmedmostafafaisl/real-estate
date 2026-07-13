<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyReport;
use Illuminate\Http\Request;

class PropertyReportController extends Controller
{
    public function store(Property $property, Request $request)
    {
        $data = $request->validate([
            'reason' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string'],
        ]);

        $report = $property->reports()->create([...$data, 'user_id' => $request->user()->id]);

        return response()->json($report, 201);
    }

    // GET /api/admin/reports
    public function index(Request $request)
    {
        return PropertyReport::with('property:id,title', 'user:id,name')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15);
    }

    public function resolve(PropertyReport $propertyReport)
    {
        $propertyReport->update(['status' => 'resolved']);
        return $propertyReport;
    }
}
