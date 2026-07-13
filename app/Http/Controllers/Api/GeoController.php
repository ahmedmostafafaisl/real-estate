<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function countries()
    {
        return Country::with('regions')->where('is_active', true)->get();
    }

    public function cities(Request $request)
    {
        return City::query()
            ->when($request->region_id, fn ($q, $v) => $q->where('region_id', $v))
            ->withCount('properties')
            ->where('is_active', true)
            ->get();
    }

    public function districts(City $city)
    {
        return $city->districts()->withCount('properties')->get();
    }

    public function storeCity(Request $request)
    {
        $data = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        return City::create($data);
    }

    public function storeDistrict(Request $request)
    {
        $data = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        return District::create($data);
    }
}
