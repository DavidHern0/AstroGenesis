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
        <div class="item-container">
            @if($hasShip)
                <form action="{{ route('home.update-ship') }}" method="POST">
                    @csrf
                    @foreach ($shipPlanets as $shipPlanet)
                        <div class="ship-item">
                            @if($hasShip)
                                @if($shipPlanet->quantity)
                                    <h4 class="item-name truncate">{{ $shipPlanet->ship->getTranslation('name', config('app.locale')) }}</h4>
                                    <p>{{__('quantity')}}: {{$shipPlanet->quantity}}</p>                    
                                    @foreach ($shipLevels as $shipLevel)
                                        @if ($shipLevel->ship_id === $shipPlanet->ship->id)
                                            <img class="item-image" src="{{ asset($shipPlanet->ship->image) }}" alt="{{$shipPlanet->ship->getTranslation('name', config('app.locale'))}}">
                                        @endif
                                    @endforeach
                                    <input type="hidden" name="shipPlanet-id" value="{{$shipPlanet->ship_id}}">
                                    <input type="hidden" name="shipPlanet-level" value="{{$shipPlanet->level}}">
                                    <input type="number" name="ship_number" value="1" max="{{$shipPlanet->quantity}}"/>
                                @endif
                            @endif
                        </div>
                    @endforeach
                    <button class="update-item-button" type="submit">{{__('update_build')}}</button>
                </form>
            @else
                <p>{{__("no_ship_message")}}</p>
            @endif
        </div>
    </section>
@endsection
