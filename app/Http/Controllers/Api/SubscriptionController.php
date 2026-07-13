<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    // GET /api/admin/subscriptions
    public function index(Request $request)
    {
        $subs = Subscription::with(['serviceProvider', 'package'])
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()
            ->paginate(15);

        return SubscriptionResource::collection($subs);
    }

    // POST /api/provider/subscribe — provider subscribes/upgrades; also generates an invoice
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

        $subtotal = $package->price;
        $taxRate = 15.00;
        $taxAmount = round($subtotal * $taxRate / 100, 2);

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'service_provider_id' => $provider->id,
            'subscription_id' => $subscription->id,
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $subtotal + $taxAmount,
            'status' => 'unpaid',
            'due_at' => now()->addDays(3),
        ]);

        return response()->json([
            'subscription' => new SubscriptionResource($subscription->load('package')),
            'invoice' => $invoice,
        ], 201);
    }
}
