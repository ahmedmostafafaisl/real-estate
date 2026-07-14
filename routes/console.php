<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Requires a real cron entry running `php artisan schedule:run` every minute
// (see RUN.md) — Laravel's own scheduler doesn't run itself.
Schedule::command('properties:expire')->daily();
Schedule::command('subscriptions:check')->daily();
