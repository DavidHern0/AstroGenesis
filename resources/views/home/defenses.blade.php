@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 
    <div class="principal_image">
        <img src="{{ asset("images/planets/Defenses.jpg") }}" alt="{{__('defenses')}}">
    </div>
    <hr class="separator">
    <section class="section_items">
        <form action="{{ route('home.update-defense') }}" method="POST">
            @csrf
        <div class="item-container">
            @foreach ($defensePlanets as $defensePlanet)
            <div class="defense-item">
                 <h4 class="item-name truncate">{{ $defensePlanet->defense->getTranslation('name', config('app.locale')) }}</h4>
                <p>{{__('quantity')}}: {{$defensePlanet->quantity}}</p>                    
                
                @foreach ($defenseLevels as $defenseLevel)
                @if ($defenseLevel->defense_id === $defensePlanet->defense->id)
                    <img class="item-image" src="{{ asset($defensePlanet->defense->image) }}" alt="{{$defensePlanet->defense->getTranslation('name', config('app.locale'))}}">
                    <div class="update-container">                                
                        <div class="cost-container">
                            <span>
                                <img src="{{ asset('images/resources/metal.gif') }}" alt="{{__('metal')}}">
                                <p class="item-cost">{{ $defenseLevel->metal_cost }}</p>
                            </span>
                            <span>
                                <img src="{{ asset('images/resources/crystal.gif') }}" alt="{{__('crystal')}}">
                                <p class="item-cost">{{ $defenseLevel->crystal_cost }}</p>
                            </span>
                            <span>
                                <img src="{{ asset('images/resources/deuterium.gif') }}" alt="{{__('deuterium')}}">
                                <p class="item-cost">{{ $defenseLevel->deuterium_cost }}</p>
                            </span>
                        </div>
                    </div>
                    @endif
                    @endforeach
                        <input type="hidden" name="defensePlanet-id[]" value="{{$defensePlanet->defense_id}}">
                        <input type="hidden" name="defensePlanet-level[]" value="{{$defensePlanet->level}}">
                        <input type="number" name="defense_number[]" value="0"/>
                    </div>
                    @endforeach
                </div>
                <button class="update-item-button" type="submit">{{__('update_build')}}</button>
            </form>
    </section>
@endsection
