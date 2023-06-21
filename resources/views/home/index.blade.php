@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <h1>{{__('home.title')}}</h1>
    <h2>{{$planet->name}}</h2>
    <h2>{{__('metal')}}: {{$Usergame->metal}}</h2>
    <h2>{{__('crystal')}}: {{$Usergame->crystal}}</h2>
    <h2>{{__('deuterium')}}: {{$Usergame->deuterium}}</h2>

    <hr>
    @foreach ($buildingPlanets as $buildingPlanet)
    <h4>{{ $buildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>
    <h4>{{ $buildingPlanet->building->getTranslation('description', config('app.locale')) }}</h4>

    @foreach ($buildingLevels as $buildingLevel)
        @if ($buildingLevel->building_id === $buildingPlanet->building->id && $buildingLevel->level === $buildingPlanet->level)
            <p>{{__('Level')}}: {{ $buildingLevel->level }}</p>
            <p>{{__('metal_cost')}}: {{ $buildingLevel->metal_cost }}</p>
            <p>{{__('crystal_cost')}}: {{ $buildingLevel->crystal_cost }}</p>
            <p>{{__('deuterium_cost')}}: {{ $buildingLevel->deuterium_cost }}</p>
            {{-- <p>Energy Cost: {{ $buildingLevel->energy_cost }}</p> --}}
            {{-- <p>Production Rate: {{ $buildingLevel->production_rate }}</p> --}}
            {{-- <p>Resource Type: {{ $buildingLevel->resource_type }}</p> --}}
        @endif
        @endforeach
        <button>{{__('update_building')}}</button>

    <hr>
@endforeach
@endsection
