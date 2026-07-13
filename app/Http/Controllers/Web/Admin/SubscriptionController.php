<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $subscriptions = Subscription::with('serviceProvider', 'package')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15)->withQueryString();

        $packages = SubscriptionPackage::all();

        return view('admin.subscriptions', compact('subscriptions', 'packages'));
    }

    public function storePackage(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'listing_limit' => ['required', 'integer', 'min:0'],
            'featured_listing_limit' => ['required', 'integer', 'min:0'],
        ]);

        SubscriptionPackage::create([...$data, 'slug' => Str::slug($data['name']), 'billing_cycle' => 'monthly']);
        return back()->with('status', 'Package created.');
    }
}
