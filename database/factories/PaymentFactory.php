<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['paid', 'paid', 'paid', 'failed', 'refunded']);

        return [
            'invoice_id' => Invoice::factory(),
            'transaction_ref' => 'TXN-' . strtoupper(Str::random(10)),
            'method' => fake()->randomElement(['visa', 'mastercard', 'mada', 'apple_pay', 'bank_transfer']),
            'amount' => fake()->randomElement([171.35, 458.85, 1148.85]),
            'status' => $status,
            'gateway_response' => ['result' => $status === 'paid' ? 'success' : $status, 'ref' => fake()->uuid()],
            'paid_at' => $status === 'paid' ? fake()->dateTimeBetween('-10 months', 'now') : null,
        ];
    }
}
