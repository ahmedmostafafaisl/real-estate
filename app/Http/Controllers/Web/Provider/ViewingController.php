<?php

namespace App\Http\Controllers\Web\Provider;

use App\Http\Controllers\Controller;
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

        return back()->with('status', 'Viewing updated.');
    }
}
