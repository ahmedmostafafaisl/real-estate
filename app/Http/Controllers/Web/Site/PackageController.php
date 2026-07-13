<?php

namespace App\Http\Controllers\Web\Site;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = SubscriptionPackage::where('is_active', true)->orderBy('price')->get();
        return view('site.packages', compact('packages'));
    }
}
