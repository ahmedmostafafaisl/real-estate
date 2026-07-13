<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    public function index()
    {
        $cities = City::with('region.country')->withCount(['properties', 'districts'])->get();
        $regions = Region::all();

        return view('admin.geo', compact('cities', 'regions'));
    }

    public function storeCity(Request $request)
    {
        $data = $request->validate([
            'region_id' => ['required', 'exists:regions,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);
        City::create($data);
        return back()->with('status', 'City added.');
    }

    public function storeDistrict(Request $request)
    {
        $data = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);
        District::create($data);
        return back()->with('status', 'District added.');
    }
}
