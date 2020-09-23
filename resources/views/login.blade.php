@extends('layout')

@section('content')
    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="username">{{ __('User') }}</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" class="form-control">
        </div>
        <input type="submit" class="btn btn-primary" value="{{ __('Login') }}">
    </form>
@endsection
