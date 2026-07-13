<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // GET /api/admin/invoices  or  /api/provider/invoices (scoped by policy/route)
    public function index(Request $request)
    {
        $query = Invoice::with('serviceProvider', 'payments');

        if ($request->user()->user_type === 'service_provider') {
            $query->where('service_provider_id', $request->user()->serviceProvider->id);
        }

        return $query->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15);
    }

    public function show(Invoice $invoice)
    {
        return $invoice->load('serviceProvider', 'payments', 'subscription.package');
    }
}
