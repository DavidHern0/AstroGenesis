<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
@php
    function formatNumber($number) {
        if ($number >= 1000000) {
            $formatVal = floor($number / 100000) / 10;
            return $formatVal . 'M';
        } elseif ($number >= 1000) {
            $formatVal = floor($number / 100) / 10; 
            return $formatVal . 'K';
        } else {
            return $number;
        }
    }   
    $emojis = [
        'spy' => '👁️',
        'attack' => '⚔️',
        'expedition' => '🌌'
    ];
@endphp

    <header>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('locale', 'en') }}"><img src="https://flagcdn.com/gb.svg" alt="UK Flag" width="24" height="18"></a>
                </li>
                <li>
                    <a href="{{ route('locale', 'es') }}"><img src="https://flagcdn.com/es.svg" alt="ES Flag" width="24" height="18"></a>
                </li>
            </ul>
        </nav>
        <h1 class="game-title"><a href="{{route('home.resources')}}">{{__('web.title')}}</a></h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="session-button" type="submit">{{__('Log Out')}}</button>
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
                        <a href="{{route('home.defenses')}}"><h4>{{__('defenses')}}</h4></a>
                        <a href="{{route('home.fleet')}}"><h4>{{__('fleet')}}</h4></a>
                        <a href="{{route('home.galaxy', $planet->galaxy_position)}}"><h4>{{__('galaxy')}}</h4></a>
                    </li>
                </ul>
            </div>
            <x-flash-messages />
            
            <div class="main-content">
                <section class="section_resources">
                    <div class="planet-name-container">
                        <span id="editIcon" class="edit-icon">&#9998;</span>
                        <h2 class="planet-name" id="planetName">{{$planet->name}}</h2>                 
                        <input type="text" id="editInput" style="display: none;" />
                    </div>
                    <section class="section_notification">
                        <div class="notification-container">
                            @if($fleets->count() > 0)
                                @foreach($fleets as $index => $fleet)
                                    <p class="fleet_p {{ $index >= 3 ? 'hidden-fleet' : '' }}">
                                        <span id="arrival_id" style="display: none">{{$fleet->id}}</span>
                                        {{ __('movement_fleet') }} 
                                        <span id="arrival_coordinates">
                                            [{{ $fleet->galaxy_position_arrival ?? '?'}}:{{ $fleet->solar_system_position_arrival ?? '?'}}]
                                        </span>
                                        (<span id="arrival_type" title={{$fleet->type}}>{{ $emojis[$fleet->type] }}</span>): 
                                        <span id="spy_arrival" class="spy_arrival">{{ $fleet->arrival }}</span>
                                    </p>
                                @endforeach

                                @if($fleets->count() > 3)
                                    <p class="fleet_p show-more" style="cursor:pointer;">...</p>
                                @endif
                            @else
                                <p>{{ __('movement_no') }}</p>
                            @endif
                            <a class="fas fa-bell notification-bell" href="{{route('home.notification')}}">
                                @if($unreadNotification)<span id="notification-count" class="notification-count">{{$unreadNotification}}</span>@endif
                            </a>
                        </div>
                    </section>

                    <div id="resources" class="resources-container">
                        <div class="resource">
                            <img src="{{ asset('images/resources/metal.gif') }}" alt="{{__('metal')}}">
                            <span id="metal" title="{{ number_format(intval($userGame->metal), 0, ',', '.') }}">
                                {{ formatNumber(intval($userGame->metal)) }}
                            </span>
                            <span title="{{ number_format($userGame->metal_storage, 0, ',', '.') }}">
                                {{ formatNumber($userGame->metal_storage) }}
                            </span>
                        </div>
                        <div class="resource">
                            <img src="{{ asset('images/resources/crystal.gif') }}" alt="{{__('crystal')}}">
                            <span id="crystal" title="{{ number_format(intval($userGame->crystal), 0, ',', '.') }}">
                                {{ formatNumber(intval($userGame->crystal)) }}
                            </span>
                            <span title="{{ number_format($userGame->crystal_storage, 0, ',', '.') }}">
                                {{ formatNumber($userGame->crystal_storage) }}
                            </span>
                        </div>
                        <div class="resource">
                            <img src="{{ asset('images/resources/deuterium.gif') }}" alt="{{__('deuterium')}}">
                            <span id="deuterium" title="{{ number_format(intval($userGame->deuterium), 0, ',', '.') }}">
                                {{ formatNumber(intval($userGame->deuterium)) }}
                            </span>
                            <span title="{{ number_format($userGame->deuterium_storage, 0, ',', '.') }}">
                                {{ formatNumber($userGame->deuterium_storage) }}
                            </span>
                        </div>
                        <div class="resource">
                            <img src="{{ asset('images/resources/energy.gif') }}" alt="{{__('energy')}}">
                            <span id="energy" title="{{ number_format($userGame->energy, 0, ',', '.') }}">
                                {{ formatNumber($userGame->energy) }}
                            </span>
                        </div>
                    </div>
                </section>

                @yield('content')
                
            </div>
            <div class="right-sidebar sidebar">
                <h2>{{__('planets')}}</h2>
                <ul>
                    <a href="{{route('home.resources')}}">
                        <li>
                            <img src="{{ asset("images/planets/worlds/$planet->biome"."_world ($planet->variation).webp") }}" alt="{{$planet->name}}">
                            <h4 id="planetListName">{{$planet->name}}</h4>
                        </li>
                    </a>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <p>David Hernández Larrea &copy; {{ date('Y') }}</p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
</body>
</html>
