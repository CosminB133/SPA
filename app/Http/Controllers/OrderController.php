<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Mail\OrderEmail;
use App\Order;
use http\Env\Response;
use Validator;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('auth')->except('store');
    }

    public function index()
    {
        $orders = Order::all();
        if ($this->request->ajax()) {
            return OrderResource::collection($orders);
        }

        return view('orders.index', ['orders' => $orders]);

    }

    public function store()
    {
        $this->request->validate([
            'name' => 'required',
            'comments' => 'required',
            'contact' => 'required',
        ]);

        if (!$this->request->session()->get('cart')) {
            if ($this->request->ajax()) {
                return response()->json(['errors' => ['cart' => 'Cart is empty!']], 422);
            }

            return redirect()->route('cart.index')->withErrors(['cart' => 'Cart is empty!'])->withInput();
        }

        $products = Product::whereIn('id', $this->request->session()->get('cart'))->get();


        $order = new Order();

        $order->fill([
            'name' => $this->request->input('name'),
            'comments' => $this->request->input('comments'),
            'contact' => $this->request->input('contact'),
            'price' => $products->sum('price'),
        ]);

        $order->save();

        foreach ($products as $product) {
            $order->products()->attach([$product->id => ['price' => $product->price]]);
        }

        Mail::to(config('services.admin.email'))->send(new OrderEmail($order, $products));

        if ($this->request->ajax()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('index');
    }

    public function show(Order $order)
    {
        if ($this->request->ajax()) {
            $response = new OrderResource($order);
            $response->withProducts();

            return $response;
        }

        return view('orders.show', ['order' => $order, 'products' => $order->products]);
    }
}
