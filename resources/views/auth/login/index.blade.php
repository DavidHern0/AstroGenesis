@extends('layouts.app')

@section('title', __('login.title'))

@section('content')
    <h1>{{ __('login.title') }}</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">{{ __('login.email') }}</label>
            <input type="email" name="email" id="email" placeholder="{{ __('login.email') }}" required>
        </div>

        <div>
            <label for="password">{{ __('login.password') }}</label>
            <input type="password" name="password" id="password" placeholder="{{ __('login.password') }}" required>
        </div>

        <div>
            <button type="submit">{{ __('login.button') }}</button>
        </div>
    </form>
@endsection
