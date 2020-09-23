@extends('layout')

@section('content')
    <h1>@lang('Add Product')</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">{{ __('Title') }}</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
        </div>
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">{{ __('Price') }}</label>
            <input type="text" name="price" id="price" class="form-control" value="{{ old('price') }}">
        </div>

        <div class="form-group">
            <label for="img">{{ __('Image') }}</label>
            <input type="file" name="img" id="img" class="form-control-file" >
        </div>

        <input type="submit" class="btn btn-primary" value="{{ __('Submit') }}">

    </form>
@endsection
