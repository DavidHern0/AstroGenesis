@extends('layouts.app')

@section('title', __('register.title'))

@section('content')
    <h1>{{ __('register.title') }}</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">{{ __('register.name') }}</label>
            <input type="text" name="name" id="name" placeholder="{{ __('register.name') }}" required>
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">{{ __('register.email') }}</label>
            <input type="email" name="email" id="email" placeholder="{{ __('register.email') }}" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">{{ __('register.password') }}</label>
            <input type="password" name="password" id="password" placeholder="{{ __('register.password') }}" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">{{ __('register.confirm_password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('register.confirm_password') }}" required>
            @error('password_confirmation')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('register.button') }}</button>
        </div>
    </form>
@endsection
