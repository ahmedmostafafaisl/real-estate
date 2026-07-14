<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\ServiceProvider;
use App\Models\SubscriptionPackage;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Property::with('city', 'images')->where('status', 'published')->where('is_featured', true)
            ->latest()->limit(6)->get();

        if ($featured->count() < 3) {
            $featured = $featured->merge(
                Property::with('city', 'images')->where('status', 'published')->latest()->limit(6)->get()
            )->unique('id')->take(6);
        }

        $categories = PropertyCategory::withCount('properties')->where('is_active', true)->limit(4)->get();

        $cities = City::withCount('properties')->orderByDesc('properties_count')->limit(6)->get();

        $providers = ServiceProvider::with('city')->withCount('properties')
            ->where('verification_status', 'verified')->orderByDesc('properties_count')->limit(4)->get();

        $packages = SubscriptionPackage::where('is_active', true)->get();

        $stats = [
            'properties' => Property::where('status', 'published')->count(),
            'providers' => ServiceProvider::where('verification_status', 'verified')->count(),
            'cities' => City::count(),
        ];

        return view('site.home', compact('featured', 'categories', 'cities', 'providers', 'packages', 'stats'));
    }
}
