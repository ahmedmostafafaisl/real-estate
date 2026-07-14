<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use App\Models\ViewingRequest;
use Illuminate\Http\Request;

class ViewingController extends Controller
{
    public function index(Request $request)
    {
        $viewings = ViewingRequest::where('service_provider_id', $request->user()->serviceProvider->id)
            ->with('property:id,title', 'user:id,name')
            ->orderBy('requested_slot')->paginate(15);

        return view('provider.viewings.index', compact('viewings'));
    }

    public function updateStatus(ViewingRequest $viewingRequest, Request $request)
    {
        abort_unless($viewingRequest->service_provider_id === $request->user()->serviceProvider->id, 403);
        $data = $request->validate(['status' => ['required', 'in:confirmed,completed,cancelled']]);
        $viewingRequest->update($data);

        if ($data['status'] === 'confirmed') {
            $viewingRequest->load('property:id,title');
            SendNotificationJob::dispatch(
                $viewingRequest->user_id, 'viewing.confirmed', 'Viewing confirmed',
                "Your viewing for \"{$viewingRequest->property->title}\" on {$viewingRequest->requested_slot->format('M j, g:ia')} is confirmed.",
                ['viewing_request_id' => $viewingRequest->id],
            );
        }

        return back()->with('status', __('provider.flash_viewing_updated'));
    }
}
