<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        return view('provider.settings', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $request->user()->id],
            'phone' => ['nullable', 'string'],
        ]);

        $request->user()->update($data);

        return back()->with('status', 'Account details saved.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate(['password' => ['required', 'string', 'min:8', 'confirmed']]);
        $request->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('status', 'Password changed.');
    }
}
