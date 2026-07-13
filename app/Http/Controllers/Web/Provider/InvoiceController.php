<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
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

    public function pay(Invoice $invoice, Request $request)
    {
        abort_unless($invoice->service_provider_id === $request->user()->serviceProvider->id, 403);
        $data = $request->validate(['method' => ['required', 'in:visa,mastercard,mada,apple_pay,bank_transfer']]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'transaction_ref' => 'TXN-' . strtoupper(Str::random(10)),
            'method' => $data['method'],
            'amount' => $invoice->total,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $invoice->update(['status' => 'paid']);

        return back()->with('status', 'Payment received — invoice marked as paid.');
    }
}
