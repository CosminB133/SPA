<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {
         $this->request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required',
            'comments' => 'required',
        ]);

        $review = new Review();

        $review->fill([
            'comment' => $this->request->input('comments'),
            'rating' => $this->request->input('rating'),
        ]);
        $review->product()->associate($this->request->input('product_id'));

        $review->save();

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('products.show', ['product' => $this->request->input('product_id')]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('products.edit', ['product' => $review->product_id]);
    }
}
