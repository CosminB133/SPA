<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required',
            'comments' => 'required',
        ]);

        $review = new Review();

        $review->fill([
            'comment' => $request->input('comments'),
            'rating' => $request->input('rating'),
        ]);
        $review->product()->associate($request->input('product_id'));

        $review->save();

        return response()->json(['message' => 'Success']);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(['message' => 'Success']);
    }
}
