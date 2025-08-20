@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 
<section class="planets_container">     
    <div class="galaxy_selector">
        <a href="{{ route('home.galaxy', ['galaxy_position' => $galaxy_position - 1]) }}"><</a>
        <input type="number" name="galaxy_position" value="{{ $galaxy_position }}" readonly />
        <a href="{{ route('home.galaxy', ['galaxy_position' => $galaxy_position + 1]) }}">></a>
    </div>
    <table class="planets_table">
        <thead>
            <tr>
                <th>{{__("position")}}</th>
                <th>{{__("image")}}</th>
                <th>{{__("name")}}</th>
                <th>{{__("player")}}</th>
                <th>{{__("actions")}}</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i <= 12; $i++)
            @php
            $individualPlanet = $planets->firstWhere('solar_system_position', $i);
            @endphp
        <tr>
            <td class="@if($individualPlanet && $individualPlanet->id == $planet->id)selected @endif table_position">
                {{$i}}
            </td>
            <td class="table_planet">
                @if($individualPlanet)
                    <img src="{{ asset("images/planets/worlds/$individualPlanet->biome"."_world ($individualPlanet->variation).webp") }}" alt="{{$individualPlanet->name}}">
                @endif
            </td>
            <td class="@if($individualPlanet && $individualPlanet->id == $planet->id)selected @endif truncate">
                {{$individualPlanet ? $individualPlanet->name : ''}}
            </td>
            <td class="@if($individualPlanet && $individualPlanet->id == $planet->id)selected @endif truncate">
                {{$individualPlanet ? $individualPlanet->user->name : ''}}
            </td>
            <td>
                @if($individualPlanet && $individualPlanet->id != $planet->id)
                
                <form action="{{ route('fleet.spy') }}" method="POST">
                    @csrf
                    <input type="hidden" name="planet-id" value="{{$individualPlanet->id}}">
                    <input type="hidden" name="galaxy-id" value="{{ $galaxy_position }}">
                    
                    <button class="galaxy_button" type="submit">{{__("spy")}}</button>
                </form>
                
                <button class="galaxy_button" type="button">{{__("transport")}}</button>

                <form action="{{ route('fleet.attack') }}" method="POST">
                    @csrf
                    <input type="hidden" name="planet-id" value="{{$individualPlanet->id}}">
                    <input type="hidden" name="galaxy-id" value="{{ $galaxy_position }}">
                    
                    <button class="galaxy_button" type="submit">{{__("attack")}}</button>
                </form>
                @endif
            </td>
        </tr>
    @endfor
    
    
    </tbody>
  </table>
</section>
@endsection
