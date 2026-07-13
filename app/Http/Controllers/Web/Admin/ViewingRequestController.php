<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ViewingRequest;

class ViewingRequestController extends Controller
{
    public function index()
    {
        $viewings = ViewingRequest::with('property:id,title', 'user:id,name', 'serviceProvider:id,office_name')
            ->latest()->paginate(15);

        return view('admin.viewing-requests', compact('viewings'));
    }
}
