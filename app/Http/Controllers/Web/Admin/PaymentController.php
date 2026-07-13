<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('serviceProvider', 'payments')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.payments', compact('invoices'));
    }

    public function refund(Payment $payment)
    {
        $payment->update(['status' => 'refunded']);
        $payment->invoice->update(['status' => 'refunded']);
        return back()->with('status', 'Payment refunded.');
    }
}
