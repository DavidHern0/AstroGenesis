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
                <p>{{__('total_cargo')}} {{__('total')}}: {{$totalCargo}}</p>   
                <p>{{__('total_construction_time')}} {{__('total')}}: {{$totalConstructionTime}}</p>   
            </div>
            <div>
                <label>
                    <input type="radio" name="type" value="expedition" required checked>
                    {{__('expedition')}}
                </label><br>
            </div>
            
            <div id="expedition_container" style="">
                <label>{{__("expedition_hours")}}</label>
                <input type="number" name="expedition_hours" value="1" min="1" max="24"/>
            </div>

            <button class="update-item-button" type="submit">{{__('send_fleet')}}</button>
        </form>
        @else
        <p>{{__("no_ship_message")}}</p>
        @endif
    </section>
@endsection
