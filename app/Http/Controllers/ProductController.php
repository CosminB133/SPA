<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function show(Product $product)
    {
        $response = new ProductResource($product);
        $response->withReviews();

        return $response;
    }

    public function store(ProductRequest $request)
    {
        $product = new Product();

        $product->fill([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
        ]);

        $product->save();

        $request->file('img')->storeAs('/public/img', $product->id);

        return response()->json(['message' => 'Success']);
    }


    public function edit(Product $product)
    {
        $response = new ProductResource($product);
        $response->withReviews();

        return $response;
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
                'title' => 'required',
                'description' => 'required',
                'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'img' => 'nullable|mimes:jpg,jpeg,png,gif',
        ]);

        $product->fill([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
        ]);

        $product->save();

        if ($request->file('img')) {
            $request->file('img')->storeAs('/public/img', $product->id);
        }

        return response()->json(['message' => 'Success']);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        Storage::delete('public/img/' . $product->id);

        return response()->json(['message' => 'Success']);
    }
}
