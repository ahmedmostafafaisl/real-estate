<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $commissions = $request->user()->serviceProvider->commissions()
            ->with('property:id,title')->latest()->paginate(15);

        return view('provider.commissions', compact('commissions'));
    }
}
