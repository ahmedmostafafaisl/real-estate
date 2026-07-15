<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyCategoryController extends Controller
{
    public function index()
    {
        return PropertyCategory::with('types')->where('is_active', true)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string'],
        ]);

        return PropertyCategory::create([...$data, 'slug' => Str::slug($data['name'])]);
    }

    public function update(Request $request, PropertyCategory $propertyCategory)
    {
        $propertyCategory->update($request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'icon' => ['sometimes', 'nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]));

        return $propertyCategory;
    }

    public function destroy(PropertyCategory $propertyCategory)
    {
        $propertyCategory->delete();

        return response()->json(['message' => __('common.api_category_deleted')]);
    }
}
