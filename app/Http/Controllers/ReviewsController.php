<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'product_id' => 'required|exists:products,id',
                'rating' => 'required',
                'comments' => 'required',
            ]
        );
        $review = new Review();
        $review->comment = $validatedData['comments'];
        $review->rating = $validatedData['rating'];
        $review->product_id = $validatedData['product_id'];
        $review->save();
        return redirect()->route('products.show', ['product' => $validatedData['product_id']]);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('products.edit', ['product' => $review->product_id]);
    }
}
