@extends('layouts.app')

@section('title', __('Register'))

@section('content')
    <h1>{{ __('Register') }}</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">{{ __('Username') }}</label>
            <input type="text" name="name" id="name" placeholder="{{ __('Username') }}" required>
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">{{ __('Email') }}</label>
            <input type="email" name="email" id="email" placeholder="{{ __('Email') }}" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password" placeholder="{{ __('Password') }}" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
            @error('password_confirmation')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit">{{ __('Register') }}</button>
        </div>
    </form>
@endsection
