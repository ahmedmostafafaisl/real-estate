<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    public function index(Request $request)
    {
        return PropertyType::query()
            ->when($request->property_category_id, fn ($q, $v) => $q->where('property_category_id', $v))
            ->where('is_active', true)
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_category_id' => ['required', 'exists:property_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'dynamic_fields' => ['nullable', 'array'],
        ]);

        return PropertyType::create([...$data, 'slug' => Str::slug($data['name'])]);
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        $propertyType->update($request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'dynamic_fields' => ['sometimes', 'array'],
            'is_active' => ['sometimes', 'boolean'],
        ]));

        return $propertyType;
    }

    public function destroy(PropertyType $propertyType)
    {
        $propertyType->delete();
        return response()->json(['message' => 'Type deleted']);
    }
}
