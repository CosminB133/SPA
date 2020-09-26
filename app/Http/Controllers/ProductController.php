<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function create()
    {
        return view('products.create', session('data', []));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
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

        return response()->json(['message' => 'Success']);
    }


    public function edit(Product $product)
    {
        return new ProductResource($product);
    }


    public function update(ProductRequest $request, Product $product)
    {
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        $request->img->move(public_path() . '/img/', $product->id);

        return response()->json(['message' => 'Success']);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Success']);
    }
}
