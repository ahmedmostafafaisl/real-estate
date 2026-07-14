<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'platform' => ['required', 'in:android,ios,web'],
        ]);

        DeviceToken::updateOrCreate(
            ['token' => $data['token']],
            ['user_id' => $request->user()->id, 'platform' => $data['platform']]
        );

        return response()->json(['registered' => true]);
    }

    public function destroy(Request $request)
    {
        $data = $request->validate(['token' => ['required', 'string']]);

        DeviceToken::where('user_id', $request->user()->id)->where('token', $data['token'])->delete();

        return response()->json(['removed' => true]);
    }
}
