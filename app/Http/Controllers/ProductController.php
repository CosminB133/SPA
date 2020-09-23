<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create', session('data', []));
    }

    public function show(Product $product)
    {
        $reviews = $product->reviews;
        return view('products.show', ['product' => $product, 'reviews' => $reviews]);
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        $path = public_path() . '/img/';
        $request->file('img')->move($path, $product->id);

        return redirect()->route('products');
    }


    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }


    public function update(ProductRequest $request, Product $product)
    {
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        $request->img->move(public_path() . '/img/', $product->id);

        return redirect()->route('products');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products');
    }
}
