@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 

    @php
    $hasShip = false;
    foreach ($shipPlanets as $shipPlanet) {
        if ($shipPlanet->quantity > 0) {
            $hasShip = true;
            break;
        }
    }
    @endphp
    
    <div class="principal_image">
        <img src="{{ asset("images/planets/Fleet (3).jpg") }}" alt="{{__('shipyard')}}">
    </div>
    <hr class="separator">
    <section class="section_items">
        @if($hasShip)
        <form action="{{ route('fleet.send') }}" method="POST">
        <div class="item-container">
                @csrf
                @foreach ($shipPlanets as $shipPlanet)
                    @if($shipPlanet->quantity > 0)
                        <div class="ship-item">
                            <h4 class="item-name">{{ $shipPlanet->ship->getTranslation('name', config('app.locale')) }}</h4>
                            <p>{{__('quantity')}}: {{$shipPlanet->quantity}}</p>                    
                                
                            @foreach ($shipLevels as $shipLevel)
                                @if ($shipLevel->ship_id === $shipPlanet->ship->id)
                                    <img class="item-image" src="{{ asset($shipPlanet->ship->image) }}" alt="{{$shipPlanet->ship->getTranslation('name', config('app.locale'))}}">
                                @endif
                            @endforeach
                            <input type="hidden" name="shipPlanet_id[]" value="{{$shipPlanet->ship_id}}">
                            <input type="number" name="ship_number[]" value="0" min="0" max="{{$shipPlanet->quantity}}" />

                        </div>
                    @endif
                @endforeach

            </div>
            <div>
                <label>
                    <input type="radio" name="type" value="expedition" required>
                    {{__('expedition')}}
                </label><br>
                
                {{-- <label>
                    <input type="radio" name="type" value="resource_transport" required>
                    {{__('resource_transport')}}
                </label><br>
                
                <label>
                    <input type="radio" name="type" value="attack" required>
                    {{__('attack')}}
                </label><br> --}}
            </div>
            
            <div id="expedition_container">
                <label>{{__("expedition_hours")}}</label>
                <input type="number" name="expedition_hours" value="0" min="0" max="24"/>
            </div>
            
            <div id="attack_resource_container" style="display: none;">
                <label>{{__("galaxy")}}</label>
                <input type="number" name="planet_gp"/>

                <label>{{__("position")}}</label>
                <input type="number" name="planet_ssp"/>
            </div>
            <button class="update-item-button" type="submit">{{__('send_fleet')}}</button>
        </form>
        @else
        <p>{{__("no_ship_message")}}</p>
        @endif
    </section>
@endsection
