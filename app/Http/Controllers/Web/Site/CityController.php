<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount(['properties' => fn ($q) => $q->where('status', 'published')])
            ->with('region')->orderBy('name')->get();

        return view('site.cities', compact('cities'));
    }
}
