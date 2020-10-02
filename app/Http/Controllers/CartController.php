<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $products = session('cart') ? Product::whereIn('id', session('cart'))->get() : [];

        if ($this->request->ajax()) {
            return ProductResource::collection($products);
        }

        return view('cart', ['products' => $products]);
    }

    public function store()
    {
        $this->request->validate([
            'id' => 'required|exists:products,id'
        ]);

        if (
            $this->request->session()->has('cart')
            && !in_array($this->request->id, $this->request->session()->get('cart'))
        ) {
            $this->request->session()->push('cart', $this->request->id);
        } else {
            $this->request->session()->put('cart', [$this->request->id]);
        }

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('index');

    }

    public function destroy()
    {
        $this->request->validate([
            'id' => 'required|exists:products,id'
        ]);

        if (!$this->request->session()->has('cart')) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Cart already empty'])->withInput();
        }

        $cart = $this->request->session()->get('cart');
        array_splice(
            $cart,
            array_search($this->request->input('id'), $cart),
            1
        );
        $this->request->session()->put('cart', $cart);

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('cart.index');
    }
}
