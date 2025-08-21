@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
<div class="principal_image">
    <img src="{{ asset("images/planets/biomes/$planet->biome-facilities.jpg") }}" alt="{{__('planet')}}">
</div>
<hr class="separator">

<section class="section_items">
    <div class="item-container">
        @foreach ($buildingPlanets as $buildingPlanet)
            <div class="building-item">
                <h4 class="item-name">{{ $buildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>

                @foreach ($buildingLevels as $buildingLevel)
                    @if ($buildingLevel->building_id === $buildingPlanet->building->id && $buildingLevel->level === $buildingPlanet->level)
                        <p class="building-cost">{{__('level')}}: {{ $buildingLevel->level }}</p>
                        <img class="item-image" src="{{ asset($buildingPlanet->building->image) }}" alt="{{$buildingPlanet->building->getTranslation('name', config('app.locale'))}}">

                        {{-- Templates ocultos para el modal --}}
                        <div class="building-info-template" style="display:none;">
                            <h4 class="item-name">{{ $buildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>
                            <p class="building-cost">{{__('level')}}: {{ $buildingLevel->level }}</p>
                            <img class="item-image" src="{{ asset($buildingPlanet->building->image) }}" alt="{{$buildingPlanet->building->getTranslation('name', config('app.locale'))}}">
                        </div>

                        <div class="update-container-template" style="display:none;">
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

                        <form class="update-form-template" action="{{ route('home.update-building') }}" method="POST" style="display:none;">
                            @csrf
                            <input type="hidden" name="buildingPlanet-id" value="{{$buildingPlanet->building_id}}">
                            <input type="hidden" name="buildingPlanet-level" value="{{$buildingPlanet->level}}">
                            <button class="update-item-button" type="submit">{{__('update_building')}}</button>
                        </form>
                    @endif
                @endforeach

                <button class="info-button" type="button" disabled>{{__('update_building')}}</button>
            </div>
        @endforeach
    </div>
</section>

<div id="info-modal" class="modal" style="display:none;">
    <div class="modal-content">
        <span id="modal-close" class="modal-close">&times;</span>
        <div id="modal-body"></div>
    </div>
</div>
@endsection
