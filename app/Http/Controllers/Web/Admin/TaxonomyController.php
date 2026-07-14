<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyCategory;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxonomyController extends Controller
{
    public function index()
    {
        $categories = PropertyCategory::withCount('properties')->with('types')->get();
        $types = PropertyType::withCount('properties')->with('category')->get();
        $features = PropertyFeature::all();

        return view('admin.taxonomy', compact('categories', 'types', 'features'));
    }

    // Str::slug() can't transliterate Arabic input, so it can return an empty string —
    // fall back to a random slug rather than risk a duplicate-empty-slug collision.
    protected function slugOrRandom(string $value): string
    {
        return Str::slug($value, '-', 'en') ?: Str::lower(Str::random(8));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        PropertyCategory::create([...$data, 'slug' => $this->slugOrRandom($data['name'])]);

        return back()->with('status', __('admin.flash_category_added'));
    }

    public function storeType(Request $request)
    {
        $data = $request->validate([
            'property_category_id' => ['required', 'exists:property_categories,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);
        PropertyType::create([...$data, 'slug' => $this->slugOrRandom($data['name'])]);

        return back()->with('status', __('admin.flash_type_added'));
    }

    public function storeFeature(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        PropertyFeature::create($data);

        return back()->with('status', __('admin.flash_feature_added'));
    }
}
