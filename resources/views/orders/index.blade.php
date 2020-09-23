@extends('layout')

@section('content')
    @foreach ($orders as $order)
        <div class="card" style="margin: 10px">
            <h1 class="card-header">{{ $order->name }}</h1>
            <div class="card-body">
                <p>{{ __('Contact details') }} : {{ $order->contact }}</p>
                <p>{{ __('Comments') }} : {{ $order->comments }}</p>
                <p>{{ __('Order price:') }} : {{ $order->price }}</p>
                <p>{{ __('Made at') }} : {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                <p>{{ __('Last update') }} {{ $order->updated_at->diffForHumans() }}</p>
                <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-primary">{{ __('Show') }}</a>
            </div>
        </div>
    @endforeach
@endsection
