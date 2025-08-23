@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <section class="planets_container">
        <div class="galaxy_selector">
            <a href="{{ route('home.galaxy', ['galaxy_position' => $galaxy_position - 1]) }}"
                @if ($galaxy_position == 1) class="disabled_galaxy_selector" @endif><</a>
                    <input type="number" name="galaxy_position" value="{{ $galaxy_position }}" readonly />
                    <a href="{{ route('home.galaxy', ['galaxy_position' => $galaxy_position + 1]) }}"
                        @if ($galaxy_position == env('MAX_GALAXY_POS')) class="disabled_galaxy_selector" @endif>></a>
        </div>
        <table class="planets_table">
            <thead>
                <tr>
                    <th>{{ __('position') }}</th>
                    <th>{{ __('image') }}</th>
                    <th>{{ __('name') }}</th>
                    <th>{{ __('player') }}</th>
                    <th>{{ __('actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $individualPlanet = $planets->firstWhere('solar_system_position', $i);
                    @endphp
                    <tr>
                        <td class="@if ($individualPlanet && $individualPlanet->id == $planet->id) selected @endif table_position">
                            {{ $i }}
                        </td>
                        <td class="table_planet">
                            @if ($individualPlanet)
                                <img src="{{ asset("images/planets/worlds/$individualPlanet->biome" . "_world ($individualPlanet->variation).webp") }}"
                                    alt="{{ $individualPlanet->name }}">
                            @endif
                        </td>
                        <td class="@if ($individualPlanet && $individualPlanet->id == $planet->id) selected @endif truncate">
                            {{ $individualPlanet ? $individualPlanet->name : '' }}
                        </td>
                        <td class="@if ($individualPlanet && $individualPlanet->id == $planet->id) selected @endif truncate">
                            {{ $individualPlanet ? $individualPlanet->user->name : '' }}
                        </td>
                        <td>
                            @if ($individualPlanet && $individualPlanet->id != $planet->id)
                                <form action="{{ route('fleet.spy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="planet-id" value="{{ $individualPlanet->id }}">
                                    <input type="hidden" name="galaxy-id" value="{{ $galaxy_position }}">

                                    <button class="galaxy_button" type="submit">{{ __('spy') }}</button>
                                </form>

                                <button class="galaxy_button" type="button" disabled>{{ __('transport') }}</button>

                                <button class="galaxy_button open-attack-modal"
                                    data-planet-id="{{ $individualPlanet->id }}"
                                    data-galaxy-id="{{ $galaxy_position }}"@if (!$hasShip) title="{{ __('no_ship_message') }}" @endif>
                                    {{ __('attack') }}
                                </button>
                            @else
                            @endif
                        </td>
                    </tr>
                @endfor


            </tbody>
        </table>
    </section>


    <div id="attackModal" class="attack-modal" style="display:none;">
        <div class="attack-modal-content">
            <span class="attack-modal-close">&times;</span>
            <section class="attack-section-items">
                <form id="attackForm" action="{{ route('fleet.send') }}" method="POST" class="attack-form">
                    @csrf
                    <div class="attack-item-grid">
                        @foreach ($shipPlanets as $shipPlanet)
                            <div class="ship-item">
                                <h4 class="item-name">
                                    {{ $shipPlanet->ship->getTranslation('name', config('app.locale')) }}
                                </h4>
                                <p class="attack-item-quantity">{{ __('quantity') }}: {{ $shipPlanet->quantity }}
                                </p>
                                @foreach ($shipLevels as $shipLevel)
                                    @if ($shipLevel->ship_id === $shipPlanet->ship->id)
                                        <img class="attack-item-image" src="{{ asset($shipPlanet->ship->image) }}"
                                            alt="{{ $shipPlanet->ship->getTranslation('name', config('app.locale')) }}">
                                    @endif
                                @endforeach
                                <input type="hidden" name="shipPlanet_id[]" value="{{ $shipPlanet->ship_id }}">
                                <input type="number" class="ship-number" name="ship_number[]" value="0" min="0"
                                    max="{{ $shipPlanet->quantity }}"
                                    data-cargo="{{ $shipPlanet->shipLevel->cargo_capacity }}"
                                    data-constructiontime="{{ $shipPlanet->shipLevel->construction_time }}" />
                            </div>
                        @endforeach
                    </div>

                    <hr class="attack-separator">

                    <div class="attack-summary">
                        <h3>{{ __('construction_time') }} {{ __('selected') }}: <span id="constructionTime">0</span>
                        </h3>
                        <h3>{{ __('cargo') }} {{ __('selected') }}: <span id="selectedCargo">0</span></h3>
                        <p>{{ __('construction_time') }} {{ __('total') }}: {{ $totalConstructionTime ?? 0 }}</p>
                        <p>{{ __('cargo') }} {{ __('total') }}: {{ $totalCargo ?? 0 }}</p>
                    </div>

                    <hr class="attack-separator">

                    @if ($hasShip)
                        <div class="attack-button-container">
                            <input type="hidden" name="type" value="attack">
                            <button class="attack-submit-button" type="submit">{{ __('attack') }}</button>
                        </div>
                    @else
                        <p class="attack-no-ship">{{ __('no_ship_message') }}</p>
                    @endif
                </form>
            </section>
        </div>
    </div>
@endsection
