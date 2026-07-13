<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        // Assumes spatie/laravel-backup writing to the "backups" disk under the app name.
        $disk = config('backup.backup.destination.disks.0', 'local');
        $files = [];

        try {
            $files = collect(Storage::disk($disk)->allFiles(config('app.name', 'Laravel')))
                ->filter(fn ($f) => str_ends_with($f, '.zip'))
                ->map(fn ($f) => [
                    'name' => basename($f),
                    'size' => round(Storage::disk($disk)->size($f) / 1048576, 1) . ' MB',
                    'date' => \Illuminate\Support\Carbon::createFromTimestamp(Storage::disk($disk)->lastModified($f)),
                ])->sortByDesc('date')->values();
        } catch (\Throwable $e) {
            // spatie/laravel-backup not installed/configured yet — show an empty, honest state.
        }

        return view('admin.backups', compact('files'));
    }
}
