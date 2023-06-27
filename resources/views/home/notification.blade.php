@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 
    <section>
        @foreach ($notifications as $notification)
            @php
                $resources = json_decode($notification->resources);
                $defenses = json_decode($notification->defenses);
                $defensePlanetsCount = count($defensePlanets);
            @endphp
            
            <div>
                <h2>{{__($notification->title)}} [{{$notification->solar_system_position}}:{{$notification->galaxy_position}}]:</h2>
                <h3>{{__($notification->body)}}:</h3>
                
                <p>{{__('metal')}}: {{$resources[0]}}</p>
                <p>{{__('crystal')}}: {{$resources[1]}}</p>
                <p>{{__('deuterium')}}: {{$resources[2]}}</p>
                
                @foreach ($defensePlanets as $index => $defensePlanet)
                    @if ($index < $defensePlanetsCount && $index < count($defenses))
                        <p>{{$defensePlanet->defense->getTranslation('name', config('app.locale'))}}: {{$defenses[$index]}}</p>
                    @endif
                @endforeach

            </div>
        @endforeach
    </section>
@endsection
