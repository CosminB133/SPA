<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $products = session('cart') ? Product::whereIn('id', session('cart'))->get() : [];

        if ($request->ajax()) {
            return ProductResource::collection($products);
        }

        return view('cart', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);

        if (
            $request->session()->has('cart')
            && !in_array($request->id, $request->session()->get('cart'))
        ) {
            $request->session()->push('cart', $request->id);
        } else {
            $request->session()->put('cart', [$request->id]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('index');

    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);

        if (!$request->session()->has('cart')) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Cart already empty'])->withInput();
        }

        $cart = $request->session()->get('cart');
        array_splice(
            $cart,
            array_search($request->input('id'), $cart),
            1
        );
        $request->session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('cart.index');
    }
}
