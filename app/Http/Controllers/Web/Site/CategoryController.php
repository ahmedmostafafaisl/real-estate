<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\PropertyCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = PropertyCategory::with(['types' => fn ($q) => $q->withCount('properties')])
            ->withCount('properties')->where('is_active', true)->get();

        return view('site.categories', compact('categories'));
    }
}
