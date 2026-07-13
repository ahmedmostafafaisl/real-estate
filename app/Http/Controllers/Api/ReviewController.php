<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Property $property, Request $request)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $review = $property->reviews()->create([...$data, 'user_id' => $request->user()->id]);

        return response()->json($review, 201);
    }

    // GET /api/admin/reviews
    public function index(Request $request)
    {
        return Review::with('property:id,title', 'user:id,name')
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()->paginate(15);
    }

    public function moderate(Review $review, Request $request)
    {
        $data = $request->validate(['status' => ['required', 'in:published,rejected']]);
        $review->update($data);
        return $review;
    }
}
