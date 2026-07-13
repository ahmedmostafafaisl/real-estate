<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionPackageController extends Controller
{
    public function index()
    {
        return SubscriptionPackage::where('is_active', true)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'listing_limit' => ['required', 'integer', 'min:0'],
            'featured_listing_limit' => ['required', 'integer', 'min:0'],
            'perks' => ['nullable', 'array'],
        ]);

        return SubscriptionPackage::create([...$data, 'slug' => Str::slug($data['name'])]);
    }

    public function update(Request $request, SubscriptionPackage $subscriptionPackage)
    {
        $subscriptionPackage->update($request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'listing_limit' => ['sometimes', 'integer', 'min:0'],
            'featured_listing_limit' => ['sometimes', 'integer', 'min:0'],
            'perks' => ['sometimes', 'array'],
            'is_active' => ['sometimes', 'boolean'],
        ]));

        return $subscriptionPackage;
    }
}
