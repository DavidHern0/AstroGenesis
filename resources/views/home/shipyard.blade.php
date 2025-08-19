@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 
    <div class="principal_image">
        <img src="{{ asset("images/planets/Shipyard.jpg") }}" alt="{{__('shipyard')}}">
    </div>
    <hr class="separator">
    <section class="section_items">
        <form action="{{ route('home.update-ship') }}" method="POST">
            @csrf
        <div class="item-container">
            @foreach ($shipPlanets as $shipPlanet)
                <div class="ship-item">
                     <h4 class="item-name">{{ $shipPlanet->ship->getTranslation('name', config('app.locale')) }}</h4>
                    <p>{{__('quantity')}}: {{$shipPlanet->quantity}}</p>                    
                    
                    @foreach ($shipLevels as $shipLevel)
                    @if ($shipLevel->ship_id === $shipPlanet->ship->id)
                        <img class="item-image" src="{{ asset($shipPlanet->ship->image) }}" alt="{{$shipPlanet->ship->getTranslation('name', config('app.locale'))}}">
                        <div class="update-container">                                
                            <div class="cost-container">
                                <span>
                                    <img src="{{ asset('images/resources/metal.gif') }}" alt="{{__('metal')}}">
                                    <p class="item-cost">{{ $shipLevel->metal_cost }}</p>
                                </span>
                                <span>
                                    <img src="{{ asset('images/resources/crystal.gif') }}" alt="{{__('crystal')}}">
                                    <p class="item-cost">{{ $shipLevel->crystal_cost }}</p>
                                </span>
                                <span>
                                    <img src="{{ asset('images/resources/deuterium.gif') }}" alt="{{__('deuterium')}}">
                                    <p class="item-cost">{{ $shipLevel->deuterium_cost }}</p>
                                </span>
                            </div>
                        </div>
                        @endif
                        @endforeach
                            <input type="hidden" name="shipPlanet-id[]" value="{{$shipPlanet->ship_id}}">
                            <input type="hidden" name="shipPlanet-level[]" value="{{$shipPlanet->level}}">
                            <input type="number" name="ship_number[]" value="0"/>
                        </div>
                        @endforeach
                    </div>
                    <button class="update-item-button" type="submit">{{__('update_build')}}</button>
                </form>
    </section>
@endsection
