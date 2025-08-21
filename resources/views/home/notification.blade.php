@extends('layouts.game')

@section('title', __('web.title'))

@section('content')
    <section>
        <div class="notifications">
            <div class="accordion">
                @foreach ($notifications as $notification)
                    @php
                        $resources = json_decode($notification->resources);
                        $defenses = json_decode($notification->defenses);
                        $defensePlanetsCount = count($defensePlanets);
                        $unreadClass = $notification->read == 0 ? 'unread' : '';

                        $enemyPlanet = \App\Models\Planet::where(
                            'solar_system_position',
                            $notification->solar_system_position,
                        )
                            ->where('galaxy_position', $notification->galaxy_position)
                            ->first();

                        $totalConstructionTime = 0;
                        if ($enemyPlanet) {
                            $totalConstructionTime =
                                \App\Models\DefensePlanet::where('planet_id', $enemyPlanet->id)
                                    ->where('quantity', '>', 0)
                                    ->join(
                                        'defense_levels',
                                        'defense_planets.defense_id',
                                        '=',
                                        'defense_levels.defense_id',
                                    )
                                    ->selectRaw('SUM(quantity * construction_time) as totalConstruction')
                                    ->value('totalConstruction') ?? 0;
                        }
                    @endphp
                    <div class="accordion-item">
                        <div class="accordion-header {{ $unreadClass }}" data-notification-id="{{ $notification->id }}">
                            <h3>{{ __($notification->title) }}
                                [{{ $notification->solar_system_position }}:{{ $notification->galaxy_position }}]:</h3>
                            <i class="fas fa-times" data-notification-id="{{ $notification->id }}"></i>
                        </div>
                        <div class="accordion-content">
                            @if ($notification->type === 'spy')
                                <h4>{{ __($notification->body) }}:</h4>
                                <hr>
                                <div class="accordion-resources">
                                    <h3>{{ __('resources') }}:</h3>
                                    <p>{{ __('metal') }}: {{ $resources[0] }}</p>
                                    <p>{{ __('crystal') }}: {{ $resources[1] }}</p>
                                    <p>{{ __('deuterium') }}: {{ $resources[2] }}</p>
                                </div>
                                <hr>
                                <div class="accordion-defenses">
                                    <h3>{{ __('defenses') }}:</h3>
                                    @foreach ($defensePlanets as $index => $defensePlanet)
                                        @if ($index < $defensePlanetsCount && $index < count($defenses))
                                            <p>{{ $defensePlanet->defense->getTranslation('name', config('app.locale')) }}:
                                                {{ $defenses[$index] }}</p>
                                        @endif
                                    @endforeach
                                    <h4>{{ __('construction_def_time') }} {{ __('total') }}:
                                        {{ $totalConstructionTime }}</h4>
                                </div>
                                <hr>
                            @endif
                            @if ($notification->type === 'attack')
                                @if ($resources[0] === 0 && $resources[1] === 0 && $resources[2] === 0)
                                    <h3>{{ __('failed_attack') }}</h3>
                                    <hr>
                                @else
                                    <h3>{{ __('succeed_attack') }}</h3>
                                    <hr>
                                    <div class="accordion-resources">
                                        <h4>{{ __($notification->body) }}:</h4>
                                        <p>{{ __('metal') }}: {{ $resources[0] }}</p>
                                        <p>{{ __('crystal') }}: {{ $resources[1] }}</p>
                                        <p>{{ __('deuterium') }}: {{ $resources[2] }}</p>
                                    </div>
                                @endif
                                <hr>
                                <div class="accordion-defenses">
                                    @if (count($defenses) > 0)
                                        <h4>{{ __('destroyed_defenses') }}:</h4>
                                        @foreach ($defensePlanets as $index => $defensePlanet)
                                            @if ($index < $defensePlanetsCount && $index < count($defenses))
                                                <p>{{ $defensePlanet->defense->getTranslation('name', config('app.locale')) }}:
                                                    {{ $defenses[$index] }}</p>
                                            @endif
                                        @endforeach
                                    @else
                                        <h4>{{ __('no_destroyed_defenses') }}</h4>
                                    @endif
                                    <hr>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
