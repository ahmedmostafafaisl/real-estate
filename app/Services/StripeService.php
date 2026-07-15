<?php

namespace App\Services;

use App\Models\Invoice;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{
    protected ?StripeClient $client = null;

    public function __construct()
    {
        $secret = config('services.stripe.secret');

        // The Stripe SDK itself throws InvalidArgumentException if given null,
        // which meant isConfigured() below was unreachable — anything that
        // resolved this class via dependency injection (e.g. InvoiceController's
        // checkout() method) would fatal-error before ever reaching the
        // graceful "not configured" check. Same defensive pattern as FcmService.
        if ($secret) {
            $this->client = new StripeClient($secret);
        }
    }

    public function isConfigured(): bool
    {
        return $this->client !== null;
    }

    /**
     * Create a real, hosted Stripe Checkout session for the given invoice.
     * The provider is redirected to $session->url to actually enter card details —
     * we never handle raw card numbers ourselves.
     *
     * Callers must check isConfigured() first — this throws if called without one.
     *
     * @throws ApiErrorException
     */
    public function createCheckoutSession(Invoice $invoice, string $successUrl, string $cancelUrl): Session
    {
        if (! $this->client) {
            throw new \RuntimeException('StripeService::createCheckoutSession() called without a configured Stripe secret. Check isConfigured() first.');
        }

        return $this->client->checkout->sessions->create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'sar',
                    'unit_amount' => (int) round($invoice->total * 100), // Stripe expects the smallest currency unit
                    'product_data' => [
                        'name' => "Keystone subscription — invoice {$invoice->invoice_number}",
                    ],
                ],
                'quantity' => 1,
            ]],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'invoice_id' => $invoice->id,
            ],
        ]);
    }
}
