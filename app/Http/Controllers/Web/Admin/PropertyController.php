<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

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
        return back()->with('status', 'Property approved and published.');
    }

    public function reject(Property $property, Request $request)
    {
        $data = $request->validate(['reason' => ['required', 'string', 'max:500']]);
        $property->reject($data['reason']);
        return back()->with('status', 'Property rejected.');
    }
}
