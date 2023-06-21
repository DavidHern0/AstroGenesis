@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <h1 class="game-title">{{__('web.title')}}</h1>
    <h2 class="planet-name">{{$planet->name}}</h2>
    <div id="resources" class="resources-container">
        <h2 class="resource">{{__('metal')}}: <span id="metal">{{intval($Usergame->metal)}}</span></h2>
        <h2 class="resource">{{__('crystal')}}: <span id="crystal">{{intval($Usergame->crystal)}}</span></h2>
        <h2 class="resource">{{__('deuterium')}}: <span id="deuterium">{{intval($Usergame->deuterium)}}</span></h2>
    </div>

    <hr class="separator">
    @foreach ($buildingPlanets as $buildingPlanet)
        <h4 class="building-name">{{ $buildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>
        <h4 class="building-description">{{ $buildingPlanet->building->getTranslation('description', config('app.locale')) }}</h4>

        @foreach ($buildingLevels as $buildingLevel)
            @if ($buildingLevel->building_id === $buildingPlanet->building->id && $buildingLevel->level === $buildingPlanet->level)
                <p class="building-level">{{__('Level')}}: {{ $buildingLevel->level }}</p>
                <p class="building-cost">{{__('metal_cost')}}: {{ $buildingLevel->metal_cost }}</p>
                <p class="building-cost">{{__('crystal_cost')}}: {{ $buildingLevel->crystal_cost }}</p>
                <p class="building-cost">{{__('deuterium_cost')}}: {{ $buildingLevel->deuterium_cost }}</p>
                {{-- <p class="building-energy-cost">{{__('Energy Cost')}}: {{ $buildingLevel->energy_cost }}</p> --}}
                {{-- <p class="building-production-rate">{{__('Production Rate')}}: {{ $buildingLevel->production_rate }}</p> --}}
                {{-- <p class="building-resource-type">{{__('Resource Type')}}: {{ $buildingLevel->resource_type }}</p> --}}
            @endif
        @endforeach
        <button class="update-building-button">{{__('update_building')}}</button>

        <hr class="separator">
    @endforeach
@endsection
