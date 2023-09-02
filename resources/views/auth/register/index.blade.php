@extends('layouts.app')

@section('title', __('Register'))

@section('content')

<form class="session" method="POST" action="{{ route('register') }}">
    @csrf
    <h1>{{ __('Register') }}</h1>
    
    <label for="name">{{ __('Username') }}</label>
    <input type="text" name="name" id="name" placeholder="{{ __('Username') }}" required>
    @error('name')
        <span class="error">{{ $message }}</span>
    @enderror

    <label for="email">{{ __('Email') }}</label>
    <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
    @error('email')
        <span class="error">{{ $message }}</span>
    @enderror

    <label for="password">{{ __('Password') }}</label>
    <input type="password" name="password" id="password" placeholder="********" required>
    @error('password')
        <span class="error">{{ $message }}</span>
    @enderror

    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="********" required>
    @error('password_confirmation')
        <span class="error">{{ $message }}</span>
    @enderror

    <button class="session-button" type="submit">{{ __('Register') }}</button>
    </form>
@endsection
