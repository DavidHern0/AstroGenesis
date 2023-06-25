@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 
    <div class="principal_image">
        <img src="{{ asset("images/planets/biomes/$planet->biome.jpg") }}" alt="{{__('planet')}}">
    </div>
    <hr class="separator">
    <section>
        <h2>{{__("planet_type")}}: {{__("$planet->biome")}}</h2>
    </section>
@endsection
