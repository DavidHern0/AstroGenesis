@extends('layouts.app')

@section('title', __('Log in'))

@section('content')
    <h1>{{ __('Log in') }}</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" placeholder="{{ __('Email') }}" required>
        </div>

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password" placeholder="{{ __('Password') }}" required>
        </div>

        <div>
            <button type="submit">{{ __('Log in') }}</button>
        </div>
    </form>
@endsection
