<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return Payment::with('invoice.serviceProvider')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15);
    }

    // POST /api/provider/invoices/{invoice}/pay — kicks off a gateway charge
    public function pay(Invoice $invoice, Request $request)
    {
        $data = $request->validate([
            'method' => ['required', 'in:visa,mastercard,mada,apple_pay,bank_transfer'],
        ]);

        // In production this calls out to the payment gateway (HyperPay/Moyasar/etc.)
        // and the webhook flips status to paid/failed. Modeled synchronously here.
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'transaction_ref' => 'TXN-'.strtoupper(Str::random(10)),
            'method' => $data['method'],
            'amount' => $invoice->total,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $invoice->update(['status' => 'paid']);

        return response()->json(['payment' => $payment, 'invoice' => $invoice], 201);
    }

    // POST /api/admin/payments/{payment}/refund
    public function refund(Payment $payment)
    {
        $payment->update(['status' => 'refunded']);
        $payment->invoice->update(['status' => 'refunded']);

        return response()->json(['message' => __('common.api_payment_refunded'), 'payment' => $payment]);
    }
}
