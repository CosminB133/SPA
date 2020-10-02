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
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('auth')->except('show');
    }

    public function index()
    {
        if ($this->request->ajax()) {
            return ProductResource::collection(Product::all());
        }
        return view('products.index', ['products' => Product::all()]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function show(Product $product)
    {
        if ($this->request->ajax()) {
            $response = new ProductResource($product);
            $response->withReviews();

            return $response;
        }

        return view('products.show', ['product' => $product, 'reviews' => $product->reviews]);
    }

    public function store()
    {
        $this->request->validate([
           'title' => 'required',
           'description' => 'required',
           'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
           'img' => 'required|mimes:jpg,jpeg,png,gif',
       ]);

        $product = new Product();

        $product->fill([
            'title' => $this->request->input('title'),
            'description' => $this->request->input('description'),
            'price' => $this->request->input('price'),
        ]);

        $product->save();

        $this->request->file('img')->storeAs('/public/img', $product->id);

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('products.index');
    }


    public function edit(Product $product)
    {
        if ($this->request->ajax()) {
            $response = new ProductResource($product);
            $response->withReviews();

            return $response;
        }

        return view('products.edit', ['product' => $product]);
    }


    public function update(Product $product)
    {
        $this->request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'img' => 'nullable|mimes:jpg,jpeg,png,gif',
        ]);

        $product->fill([
            'title' => $this->request->input('title'),
            'description' => $this->request->input('description'),
            'price' => $this->request->input('price'),
        ]);

        $product->save();

        if ($this->request->file('img')) {
            $this->request->file('img')->storeAs('/public/img', $product->id);
        }

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('products.index');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        Storage::delete('public/img/' . $product->id);

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('products.index');
    }
}
