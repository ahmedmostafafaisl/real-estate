<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index()
    {
        // Requires spatie/laravel-activitylog's migration to be published & run
        // (php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider").
        $logs = class_exists(\Spatie\Activitylog\Models\Activity::class)
            ? \Spatie\Activitylog\Models\Activity::latest()->with('causer')->paginate(20)
            : collect();

        return view('admin.activity', compact('logs'));
    }
}
