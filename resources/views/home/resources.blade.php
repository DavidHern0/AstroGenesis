@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <div class="principal_image">
        <img src="{{ asset("images/planets/biomes/$planet->biome-resources.jpg") }}" alt="{{__('planet')}}">
    </div>
    <hr class="separator">
        <section class="section_items">
            <div class="item-container">
                @foreach ($buildingPlanets as $buildingPlanet)
                    <div class="building-item">
                         <h4 class="item-name truncate">{{ $buildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>
                        
                        @foreach ($buildingLevels as $buildingLevel)
                            @if ($buildingLevel->building_id === $buildingPlanet->building->id && $buildingLevel->level === $buildingPlanet->level)
                                <p class="building-cost">{{__('level')}}: {{ $buildingLevel->level }}</p>
                                <img class="item-image" src="{{ asset($buildingPlanet->building->image) }}" alt="{{$buildingPlanet->building->getTranslation('name', config('app.locale'))}}">
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
                                            <img src="{{ asset('images/resources/energy.gif') }}" alt="{{__('energy')}}">
                                            <p class="building-cost">{{ $buildingLevel->energy_cost }}</p>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <form action="{{ route('home.update-building') }}" method="POST">
                            @csrf
                            <input type="hidden" name="buildingPlanet-id" value="{{$buildingPlanet->building_id}}">
                            <input type="hidden" name="buildingPlanet-level" value="{{$buildingPlanet->level}}">
                            <button class="update-item-button" type="submit" data-id="{{$buildingLevel->id}}">{{__('update_building')}}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </section>
@endsection
