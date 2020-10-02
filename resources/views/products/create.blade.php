@extends('layout')

@section('content')
    <h1>{{ __('Add Product') }}</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
        </div>

        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
        </div>

        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
        </div>

        @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="img">{{ __('Image') }}</label>
            <input type="file" name="img" id="img" class="form-control-file" >
        </div>

        @error('img')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="submit" class="btn btn-primary" value="{{ __('Submit') }}">

    </form>
@endsection
