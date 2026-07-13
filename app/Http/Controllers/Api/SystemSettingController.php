<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function index()
    {
        return SystemSetting::pluck('value', 'key');
    }

    public function update(Request $request)
    {
        $data = $request->validate(['settings' => ['required', 'array']]);

        foreach ($data['settings'] as $key => $value) {
            SystemSetting::set($key, $value);
        }

        return SystemSetting::pluck('value', 'key');
    }
}
