<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('site.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
            'user_type' => 'customer',
        ]);
        $user->assignRole('customer');

        Auth::login($user);

        return redirect()->route('home')->with('status', __('site.welcome_message'));
    }

    public function createProvider()
    {
        return view('site.register-provider', ['cities' => City::orderBy('name')->get()]);
    }

    public function storeProvider(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'office_name' => ['required', 'string', 'max:255'],
            'provider_type' => ['required', 'in:agency,broker,owner,developer'],
            'city_id' => ['required', 'exists:cities,id'],
            'commercial_register_no' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'],
            'password' => Hash::make($data['password']), 'user_type' => 'service_provider',
        ]);
        $user->assignRole('service_provider');

        ServiceProvider::create([
            'user_id' => $user->id, 'office_name' => $data['office_name'], 'provider_type' => $data['provider_type'],
            'city_id' => $data['city_id'], 'commercial_register_no' => $data['commercial_register_no'] ?? null,
            'verification_status' => 'pending',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('status', __('site.application_submitted'));
    }
}
