<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Order;
use http\Env\Response;
use Validator;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();

        return view('orders.index', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'comments' => 'required',
                'contact' => 'required',
            ]
        );

        if (!$request->session()->get('cart')) {
            return response()->json(['errors' => ['cart' => 'Cart is empty!']], 422);
        }

        $products = array_map('App\Product::find', $request->session()->get('cart'));
        $orderPrice = array_reduce(
            $products,
            function ($sum, $product) {
                return $sum + $product->price;
            }
        );
        $order = new Order();
        $order->name = $validatedData['name'];
        $order->comments = $validatedData['comments'];
        $order->contact = $validatedData['contact'];
        $order->price = $orderPrice;
        $order->save();

        foreach ($products as $product) {
            $order->products()->attach([$product->id => ['price' => $product->price]]);
        }

        Mail::to(config('services.admin.email'))->send(new OrderEmail($order, $products));

        return response()->json(['message' => 'Success']);
    }

    public function show(Order $order)
    {
        $products = $order->products;

        return view('orders.show', ['order' => $order, 'products' => $products]);
    }
}
