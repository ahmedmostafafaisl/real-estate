<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyReport;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('property:id,title', 'user:id,name')->latest()->paginate(10);
        $reports = PropertyReport::with('property:id,title', 'user:id,name')->latest()->paginate(10, ['*'], 'reports_page');

        return view('admin.reviews', compact('reviews', 'reports'));
    }

    public function moderate(Review $review, Request $request)
    {
        $data = $request->validate(['status' => ['required', 'in:published,rejected']]);
        $review->update($data);

        return back()->with('status', __('admin.flash_review_moderated'));
    }

    public function resolve(PropertyReport $report)
    {
        $report->update(['status' => 'resolved']);

        return back()->with('status', __('admin.flash_report_resolved'));
    }
}
