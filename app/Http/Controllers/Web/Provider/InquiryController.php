<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $providerId = $request->user()->serviceProvider->id;

        $inquiries = Inquiry::whereHas('property', fn ($q) => $q->where('service_provider_id', $providerId))
            ->with('property:id,title', 'user:id,name')
            ->latest()->paginate(15);

        return view('provider.inquiries.index', compact('inquiries'));
    }

    public function respond(Inquiry $inquiry, Request $request)
    {
        abort_unless($inquiry->property->service_provider_id === $request->user()->serviceProvider->id, 403);
        $inquiry->update(['status' => 'responded']);

        return back()->with('status', __('provider.flash_inquiry_responded'));
    }
}
