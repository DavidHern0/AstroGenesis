@extends('layouts.app')

@section('title', __('Log in'))

@section('content')

<form class="session" method="POST" action="{{ route('login') }}">
    @csrf
        <h1>{{ __('Log in') }}</h1>

        <label for="email">{{ __('Email') }}</label>
        <input type="email" name="email" id="email" placeholder="example@gmail.com" required>
        <label for="password">{{ __('Password') }}</label>
        <input type="password" name="password" id="password" placeholder="********" required>

        <button class="session-button" type="submit">{{ __('Log in') }}</button>
    </form>
@endsection
