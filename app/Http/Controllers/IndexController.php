<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $products = session('cart') ? Product::whereNotIn('id', session('cart'))->get() : Product::all();

        if ($request->ajax()) {
            return ProductResource::Collection($products);
        }

        return view('index', ['products' => $products]);
    }
}
