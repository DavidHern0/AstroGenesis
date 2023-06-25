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
        <div class="container">
            <div class="left-sidebar sidebar">
                <ul>
                    <li>
                        <h2>{{__('list')}}</h2>
                        <a href="{{route('home.index')}}"><h4>{{__('overview')}}</h4></a>
                        <a href="{{route('home.resources')}}"><h4>{{__('resources')}}</h4></a>
                        <a href="{{route('home.facilities')}}"><h4>{{__('facilities')}}</h4></a>
                        <a href="{{route('home.shipyard')}}"><h4>{{__('shipyard')}}</h4></a>
                        <a href="{{route('home.galaxy', $planet->galaxy_position)}}"><h4>{{__('galaxy')}}</h4></a>
                    </li>
                </ul>
            </div>
            <x-flash-messages />
            
            <div class="main-content">
                <section class="section_resources">
                    <h1 class="game-title">{{__('web.title')}}</h1>
                    <div class="planet-name-container">
                        <span id="editIcon" class="edit-icon">&#9998;</span>
                        <h2 class="planet-name" id="planetName">{{$planet->name}}</h2>                 
                        <input type="text" id="editInput" style="display: none;" />
                    </div>
                       
                    <div id="resources" class="resources-container">
                        <div class="resource">
                            <img src="{{ asset('images/resources/metal.gif') }}" alt="{{__('metal')}}">
                            <span id="metal">{{intval($userGame->metal)}}</span>
                            <span>{{$userGame->metal_storage}}</span>
                        </div>
                        <div class="resource">
                            <img src="{{ asset('images/resources/crystal.gif') }}" alt="{{__('crystal')}}">
                            <span id="crystal">{{intval($userGame->crystal)}}</span>
                            <span>{{$userGame->crystal_storage}}</span>
                        </div>
                        <div class="resource">
                            <img src="{{ asset('images/resources/deuterium.gif') }}" alt="{{__('deuterium')}}">
                            <span id="deuterium">{{intval($userGame->deuterium)}}</span>
                            <span>{{$userGame->deuterium_storage}}</span>
                        </div>
                        <div class="resource">
                            <img src="{{ asset('images/resources/energy.gif') }}" alt="{{__('energy')}}">
                            <span id="energy">{{$userGame->energy}}</span>
                        </div>
                    </div>
                </section>

                @yield('content')
                
            </div>
                <div class="right-sidebar sidebar">
                    <h2>{{__('planets')}}</h2>
                    <ul>
                        <li>
                            <img src="{{ asset("images/planets/worlds/$planet->biome"."_world ($planet->variation).webp") }}" alt="{{$planet->name}}">
                            <h4 id="planetListName">{{$planet->name}}</h4>
                        </li>
                    </ul>
                </div>
                </div>
    </main>

    <footer>
        <p>David Hernández Larrea &copy; {{ date('Y') }}</p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>