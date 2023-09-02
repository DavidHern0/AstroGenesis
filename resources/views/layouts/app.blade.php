<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav class="header-item">
            <ul>
                <li>
                    <a href="{{ route('locale', 'en') }}">EN</a>
                </li>
                <li>
                    <a href="{{ route('locale', 'es') }}">ES</a>
                </li>
            </ul>
        </nav>
        <h1 class="game-title header-item"><a href="/">{{__('web.title')}}</a></h1>
        <div class="header-item">
            <a href="{{ route('login') }}" class="login-link">{{__('Log In')}}</a>
            <a href="{{ route('register') }}" class="register-link">{{__('Register')}}</a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>

    <footer>
        <p>David Hernández Larrea &copy; {{ date('Y') }}</p>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>