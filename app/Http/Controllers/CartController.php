<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function index()
    {
        $products = session('cart') ? Product::whereIn('id', session('cart'))->get() : [];
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:products,id'
            ]
        );

        if ($request->session()->has('cart')) {
            if (!in_array($request->id, $request->session()->get('cart'))) {
                $request->session()->push('cart', $request->id);
            }
        } else {
            $request->session()->put('cart', [$request->id]);
        }

        return response()->json(['message' => 'Success']);
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:products,id'
            ]
        );

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            array_splice(
                $cart,
                array_search($request->id, $cart),
                1
            );
            $request->session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Success']);
    }
}
