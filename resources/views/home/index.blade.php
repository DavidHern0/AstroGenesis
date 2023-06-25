@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
<div class="container">
    <div class="left-sidebar sidebar">
        <ul>
            <li>
                <h2>{{__('list')}}</h2>
                <h4>{{__('overview')}}</h4>
                <h4>{{__('resources')}}</h4>
                <h4>{{__('installations')}}</h4>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <section class="section_resources">
        <h1 class="game-title">{{__('web.title')}}</h1>
        <h2 class="planet-name">{{$planet->name}}</h2>
            {{-- <h2 class="resource">{{__('metal')}}: <span id="metal">{{intval($userGame->metal)}}</span></h2> --}}
            {{-- <h2 class="resource">{{__('crystal')}}: <span id="crystal">{{intval($userGame->crystal)}}</span></h2> --}}
            {{-- <h2 class="resource">{{__('deuterium')}}: <span id="deuterium">{{intval($userGame->deuterium)}}</span></h2> --}}
            {{-- <h2 class="resource">{{__('energy')}}: <span id="energy">0</span></h2> --}}
            
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
            <img src="{{ asset('images/planets/Ogame_Jungle_Resources.webp') }}" alt="{{__('metal')}}">
        </section>    
        <hr class="separator">
        <section class="section_buildings">
            <div class="building-container">
                @foreach ($buildingPlanets as $buildingPlanet)
                    <div class="building-item">
                        <h4 class="building-name">{{ $buildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>
                        {{-- <h4 class="building-description">{{ $buildingPlanet->building->getTranslation('description', config('app.locale')) }}</h4> --}}
                        
                        @foreach ($buildingLevels as $buildingLevel)
                        @if ($buildingLevel->building_id === $buildingPlanet->building->id && $buildingLevel->level === $buildingPlanet->level)
                            <p class="building-cost">{{__('level')}}: {{ $buildingLevel->level }}</p>
                            <img class="building-image" src="{{ asset($buildingPlanet->building->image) }}" alt="{{$planet->name}}">
                            <div class="update-container">                                
                                <p>{{__('update_level')}} {{$buildingLevel->level+1}}:</p>                    
                                <div class="cost-container">
                                    <span>
                                        <img src="{{ asset('images/resources/metal.gif') }}" alt="{{__('metal')}}">
                                        <p class="building-cost">{{ $buildingLevel->metal_cost }}</p>
                                    </span>
                                    <span>
                                        <img src="{{ asset('images/resources/crystal.gif') }}" alt="{{__('crystal')}}">
                                        <p class="building-cost">{{ $buildingLevel->crystal_cost }}</p>
                                    </span>
                                    <span>
                                        <img src="{{ asset('images/resources/deuterium.gif') }}" alt="{{__('deuterium')}}">
                                        <p class="building-cost">{{ $buildingLevel->deuterium_cost }}</p>
                                    </span>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <form action="{{ route('home.update-building') }}" method="POST">
                                @csrf
                                <input type="hidden" name="buildingPlanet-id" value="{{$buildingPlanet->building_id}}">
                                <input type="hidden" name="buildingPlanet-level" value="{{$buildingPlanet->level}}">
                                <button class="update-building-button" type="submit">{{__('update_building')}}</button>
                            </form>
                    </div>
                @endforeach
            </div>
        </section>
        
    </div>
    
    <div class="right-sidebar sidebar">
        <h2>{{__('planets')}}</h2>
        <ul>
            <li>
                <img src="{{ asset('images/planets/Planet.png') }}" alt="{{$planet->name}}">
                <h4>{{$planet->name}}</h4>
            </li>
        </ul>
    </div>
</div>
@endsection
