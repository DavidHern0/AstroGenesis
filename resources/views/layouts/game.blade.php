<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
            <ul>
                <ul>
                    <a href="{{ route('locale', 'en') }}">EN</a>
                    <a href="{{ route('locale', 'es') }}">ES</a>
                </ul>
            </ul>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">{{__('Log Out')}}</button>
        </form>
    </header>

    <main>
        <x-flash-messages />
        @yield('content')
    </main>

    <footer>
        <p>David Hernández Larrea &copy; {{ date('Y') }}</p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>