@extends('layout')

@section('content')
    @foreach ($products as $product)
        <div class="row" style="margin: 10px">
            <div class="col-md-3">
                <img src="{{  Storage::url('img/' . $product->id) }}" alt="{{ __('product image') }}" class="img-fluid"
                     style="max-height: 150px; margin-right: 5px">
            </div>
            <div class="col-md-6">
                <h4>{{ $product->title }}</h4>
                <p>{{ $product->description }}</p>
                <p>{{ $product->price }}</p>
            </div>
            <div class="col-md-3">
                <form action="{{ route('cart.destroy') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="submit" value="{{ __('Remove') }}" class="btn btn-danger">
                </form>
            </div>
        </div>
    @endforeach

    @error('cart')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <form action="{{ route('orders.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">{{ __('Name :') }}</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
        </div>

        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="contact">{{ __('Contact details :') }}</label>
            <input type="text" class="form-control" name="contact" id="contact" value="{{ old('contact') }}">
        </div>

        @error('contact')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="comments">{{ __('Comments :') }}</label>
            <input type="text" class="form-control" name="comments" id="comments" value="{{ old('comments') }}">
        </div>

        @error('comments')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="submit" class="btn btn-success" value="{{ __('Submit') }}">
    </form>
@endsection
