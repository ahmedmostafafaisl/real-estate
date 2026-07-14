<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $commissions = Commission::with('property', 'serviceProvider')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15)->withQueryString();

        return view('admin.commissions', compact('commissions'));
    }

    public function markPaid(Commission $commission)
    {
        $commission->update(['status' => 'paid', 'paid_at' => now()]);

        return back()->with('status', __('admin.flash_commission_paid'));
    }
}
