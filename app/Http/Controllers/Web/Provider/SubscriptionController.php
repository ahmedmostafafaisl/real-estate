<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $provider = $request->user()->serviceProvider;
        $current = $provider->activeSubscription()->with('package')->first();
        $packages = SubscriptionPackage::where('is_active', true)->get();

        $daysLeft = $current ? max(0, now()->diffInDays($current->ends_at, false)) : 0;
        $used = $provider->properties()->count();

        return view('provider.subscription', compact('current', 'packages', 'daysLeft', 'used'));
    }

    public function subscribe(Request $request)
    {
        $data = $request->validate(['subscription_package_id' => ['required', 'exists:subscription_packages,id']]);
        $provider = $request->user()->serviceProvider;
        $package = SubscriptionPackage::findOrFail($data['subscription_package_id']);

        $provider->subscriptions()->where('status', 'active')->update(['status' => 'cancelled']);

        $subscription = $provider->subscriptions()->create([
            'subscription_package_id' => $package->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $taxAmount = round($package->price * 0.15, 2);

        Invoice::create([
            'invoice_number' => 'INV-'.strtoupper(Str::random(8)),
            'service_provider_id' => $provider->id,
            'subscription_id' => $subscription->id,
            'subtotal' => $package->price,
            'tax_rate' => 15.00,
            'tax_amount' => $taxAmount,
            'total' => $package->price + $taxAmount,
            'status' => 'unpaid',
            'due_at' => now()->addDays(3),
        ]);

        return redirect()->route('provider.subscription')->with('status', __('provider.flash_subscription_switched', ['plan' => $package->name]));
    }
}
