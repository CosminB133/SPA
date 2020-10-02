@extends('layout')

@section('content')
    <h1>{{ __('Edit Product') }} </h1>
    <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $product['title'] }}">
        </div>

        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="description" cols="30" rows="10"
                      class="form-control">{{ $product['description'] }}</textarea>
        </div>

        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ $product['price'] }}">
        </div>

        @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror


        <img src="{{  Storage::url('img/' . $product->id) }}" class="img-fluid" alt="{{ __('product image') }}">

        <div class="form-group">
            <label for="img">{{ __('Image') }}</label>
            <input type="file" name="img" id="img" class="form-control-file">
        </div>

        @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="submit" class="btn btn-primary" value="{{ __('Submit') }}">
    </form>

    @foreach ($product->reviews as $review)
        <div class="card">
            <div class="card-body">
                <h3>{{ $review->rating }}</h3>
                <p>{{ $review->comment }}</p>

                <form action="{{ route('reviews.destroy', ['review' => $review->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="{{ __('Delete') }}" class="btn btn-danger">
                </form>
            </div>
        </div>
    @endforeach
@endsection
