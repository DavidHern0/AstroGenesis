@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <h1>{{__('home.title')}}</h1>
    <h2>{{$planet->name}}</h2>
    <h2>{{__('metal')}}: {{$Usergame->metal}}</h2>
    <h2>{{__('crystal')}}: {{$Usergame->crystal}}</h2>
    <h2>{{__('deuterium')}}: {{$Usergame->deuterium}}</h2>

    <hr>
    @foreach ($BuildingPlanets as $BuildingPlanet)
        <h4>{{ $BuildingPlanet->building->getTranslation('name', config('app.locale')) }}</h4>
        <h4>{{ $BuildingPlanet->building->getTranslation('description', config('app.locale')) }}</h4>
        <h4>{{ $BuildingPlanet->level}}</h4>
        <hr>
    @endforeach
@endsection
