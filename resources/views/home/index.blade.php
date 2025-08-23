@extends('layouts.game')

@section('title', __('web.title'))

@section('content') 
<div class="principal_image image-title-container">
        <img src="{{ asset("images/planets/biomes/$planet->biome.jpg") }}" alt="{{__('planet')}}">
    <h2 class="title">{{ __(request()->segment(1)) }}</h2>
    </div>
    <hr class="separator">
    <section>
        <h2>{{__("planet_type")}}: {{__("$planet->biome")}}</h2>
    </section>
@endsection
