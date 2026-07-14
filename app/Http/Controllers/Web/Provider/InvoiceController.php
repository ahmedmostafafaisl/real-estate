<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = $request->user()->serviceProvider->invoices()
            ->with('payments')->latest()->paginate(15);

        return view('provider.invoices.index', compact('invoices'));
    }

    // Real Stripe Checkout — the provider is redirected to Stripe's own hosted
    // page to enter card details; we never see or store the card number.
    // Requires STRIPE_KEY/STRIPE_SECRET in .env — see RUN.md.
    public function checkout(Invoice $invoice, Request $request, StripeService $stripe)
    {
        abort_unless($invoice->service_provider_id === $request->user()->serviceProvider->id, 403);
        abort_if($invoice->status === 'paid', 400, 'This invoice is already paid.');
        abort_unless($stripe->isConfigured(), 503, 'Card payments are not configured yet. Add STRIPE_KEY/STRIPE_SECRET to .env.');

        $session = $stripe->createCheckoutSession(
            $invoice,
            route('provider.invoices.checkout.success', $invoice),
            route('provider.invoices.index'),
        );

        return redirect($session->url);
    }

    // Landing page after Stripe redirects back. The invoice may not be marked
    // paid yet at this exact moment — the webhook is what actually confirms it,
    // and webhooks can arrive a few seconds after this redirect.
    public function checkoutSuccess(Invoice $invoice, Request $request)
    {
        abort_unless($invoice->service_provider_id === $request->user()->serviceProvider->id, 403);

        return redirect()->route('provider.invoices.index')->with('status', __('provider.flash_checkout_pending'));
    }

    // Manual path for bank transfers only — these aren't processed by Stripe,
    // so the provider (or an admin) confirms them by hand after reconciling
    // with the actual bank statement.
    public function pay(Invoice $invoice, Request $request)
    {
        abort_unless($invoice->service_provider_id === $request->user()->serviceProvider->id, 403);
        abort_if($invoice->status === 'paid', 400, 'This invoice is already paid.');

        Payment::create([
            'invoice_id' => $invoice->id,
            'transaction_ref' => 'BANK-'.strtoupper(Str::random(10)),
            'method' => 'bank_transfer',
            'amount' => $invoice->total,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $invoice->update(['status' => 'paid']);

        return back()->with('status', __('provider.flash_payment_received'));
    }
}
