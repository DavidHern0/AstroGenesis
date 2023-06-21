@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <h1>{{__('home.title')}}</h1>
    <h2>{{$planet->name}}</h2>
    <div id="resources">
        <h2>{{__('metal')}}: <span id="metal">{{intval($Usergame->metal)}}</span></h2>
        <h2>{{__('crystal')}}: <span id="crystal">{{intval($Usergame->crystal)}}</span></h2>
        <h2>{{__('deuterium')}}: <span id="deuterium">{{intval($Usergame->deuterium)}}</span></h2>
    </div>

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
