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
    
    <div class="principal_image image-title-container">
        <img src="{{ asset("images/planets/Fleet (3).jpg") }}" alt="{{__('shipyard')}}">
    <h2 class="title">{{ __(request()->segment(2)) }}</h2>
    </div>
    <hr class="separator">
    <section class="section_items">
        @if($hasShip)
        <form action="{{ route('fleet.send') }}" method="POST">
        <div class="item-container">
                @csrf
                @foreach ($shipPlanets as $shipPlanet)
                        <div class="ship-item @if($shipPlanet->quantity <= 0) no-ship @endif @if(in_array($shipPlanet->ship_id, [11, 12, 13, 14])) ship-no-selectable @endif">
                                            
                            <h4 class="item-name">{{ $shipPlanet->ship->getTranslation('name', config('app.locale')) }}</h4>
                            <p>{{__('quantity')}}: {{$shipPlanet->quantity}}</p>                    
                                
                            @foreach ($shipLevels as $shipLevel)
                                @if ($shipLevel->ship_id === $shipPlanet->ship->id)
                                    <img class="item-image" src="{{ asset($shipPlanet->ship->image) }}" alt="{{$shipPlanet->ship->getTranslation('name', config('app.locale'))}}">
                                @endif
                            @endforeach
                            <input type="hidden" name="shipPlanet_id[]" value="{{$shipPlanet->ship_id}}">
                            <input type="number" class="ship-number" name="ship_number[]" value=@if(in_array($shipPlanet->ship_id, [11, 12, 13, 14])) {{0}} @else {{$shipPlanet->quantity}} @endif min="0" max="{{$shipPlanet->quantity}}" data-cargo="{{$shipPlanet->shipLevel->cargo_capacity}}" data-constructiontime="{{$shipPlanet->shipLevel->construction_time}}"/>

                            
                        </div>
                @endforeach
            </div>
                <hr>
            <div>
                <h3>{{__('construction_time')}} {{__('selected')}}: <span id="constructionTime">0</span></h3>
                <h3>{{__('cargo')}} {{__('selected')}}: <span id="selectedCargo">0</span></h3>
                <p>{{__('construction_time')}} {{__('total')}}: {{$totalConstructionTime ?? 0}}</p>   
                <p>{{__('cargo')}} {{__('total')}}: {{$totalCargo ?? 0}}</p>   
            </div>
                <hr>
            <div id="expedition_container">
                <label>
                    <input type="radio" name="type" value="expedition" required checked>
                    {{__('expedition')}}
                </label><br>
            
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
