<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $provider = $request->user()->serviceProvider;
        $cities = City::all();

        return view('provider.profile', compact('provider', 'cities'));
    }

    public function update(Request $request)
    {
        $provider = $request->user()->serviceProvider;

        $data = $request->validate([
            'office_name' => ['required', 'string', 'max:255'],
            'provider_type' => ['required', 'in:agency,broker,owner,developer'],
            'city_id' => ['required', 'exists:cities,id'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
        ]);

        $provider->update($data);

        return back()->with('status', 'Office profile updated.');
    }
}
