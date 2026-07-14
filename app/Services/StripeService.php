<?php

namespace App\Services;

use App\Models\Invoice;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService
{
    protected StripeClient $client;

    public function __construct()
    {
        $this->client = new StripeClient(config('services.stripe.secret'));
    }

    public function isConfigured(): bool
    {
        return (bool) config('services.stripe.secret');
    }

    /**
     * Create a real, hosted Stripe Checkout session for the given invoice.
     * The provider is redirected to $session->url to actually enter card details —
     * we never handle raw card numbers ourselves.
     *
     * @throws ApiErrorException
     */
    public function createCheckoutSession(Invoice $invoice, string $successUrl, string $cancelUrl): Session
    {
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
