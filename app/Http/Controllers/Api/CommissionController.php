<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with('property', 'serviceProvider');

        if ($request->user()->user_type === 'service_provider') {
            $query->where('service_provider_id', $request->user()->serviceProvider->id);
        }

        return $query->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15);
    }

    public function markPaid(Commission $commission)
    {
        $commission->update(['status' => 'paid', 'paid_at' => now()]);
        return $commission;
    }
}
