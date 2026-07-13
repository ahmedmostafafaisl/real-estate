<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $subtotal = fake()->randomElement([149, 399, 999]);
        $taxRate = 15.00;
        $taxAmount = round($subtotal * $taxRate / 100, 2);
        $status = fake()->randomElement(['paid', 'paid', 'paid', 'unpaid', 'void', 'refunded']);

        return [
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'service_provider_id' => \App\Models\ServiceProvider::factory(),
            'subscription_id' => Subscription::factory(),
            'subtotal' => $subtotal,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => $subtotal + $taxAmount,
            'status' => $status,
            'due_at' => fake()->dateTimeBetween('-10 months', '+1 month'),
        ];
    }
}
