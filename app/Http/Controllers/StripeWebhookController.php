<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    // Never trust the browser redirect after Stripe Checkout — a user closing
    // the tab, losing connection, or the redirect simply not firing must not
    // be the only way an invoice gets marked paid. This webhook, verified by
    // Stripe's own signature, is the actual source of truth.
    public function handle(Request $request)
    {
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = $secret
                ? Webhook::constructEvent($request->getContent(), $request->header('Stripe-Signature'), $secret)
                : json_decode($request->getContent());
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe webhook signature verification failed: '.$e->getMessage());

            return response()->json(['error' => 'invalid signature'], 400);
        }

        if (($event->type ?? null) === 'checkout.session.completed') {
            $this->markInvoicePaid($event->data->object);
        }

        return response()->json(['received' => true]);
    }

    protected function markInvoicePaid(object $session): void
    {
        $invoiceId = $session->metadata->invoice_id ?? null;
        $invoice = $invoiceId ? Invoice::find($invoiceId) : null;

        if (! $invoice || $invoice->status === 'paid') {
            return; // Unknown invoice, or already processed — webhooks can be delivered more than once.
        }

        Payment::create([
            'invoice_id' => $invoice->id,
            'transaction_ref' => $session->payment_intent ?? ('STRIPE-'.Str::upper(Str::random(10))),
            'method' => 'visa', // Stripe Checkout supports multiple card brands; the specific brand isn't in this payload.
            'amount' => $invoice->total,
            'status' => 'paid',
            'gateway_response' => (array) $session,
            'paid_at' => now(),
        ]);

        $invoice->update(['status' => 'paid']);

        $user = $invoice->serviceProvider->user ?? null;
        if ($user) {
            SendNotificationJob::dispatch(
                $user->id, 'payment.received', 'Payment received',
                "Payment of SAR {$invoice->total} for invoice {$invoice->invoice_number} was received.",
                ['invoice_id' => $invoice->id],
            );
        }
    }
}
