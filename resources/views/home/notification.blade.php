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
                                <div class="accordion-resources">
                                    <p>{{ __('metal') }}: {{ $resources[0] }}</p>
                                    <p>{{ __('crystal') }}: {{ $resources[1] }}</p>
                                    <p>{{ __('deuterium') }}: {{ $resources[2] }}</p>
                                </div>
                                <div class="accordion-defenses">
                                    @foreach ($defensePlanets as $index => $defensePlanet)
                                        @if ($index < $defensePlanetsCount && $index < count($defenses))
                                            <p>{{ $defensePlanet->defense->getTranslation('name', config('app.locale')) }}:
                                                {{ $defenses[$index] }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            @if ($notification->type === 'attack')
                                @if ($resources[0] === 0 && $resources[1] === 0 && $resources[2] === 0)
                                    <h3>{{ __('failed_attack') }}</h3>
                                @else
                                    <h3>{{ __('succeed_attack') }}</h3>
                                    <div class="accordion-resources">
                                        <h4>{{ __($notification->body) }}:</h4>
                                        <p>{{ __('metal') }}: {{ $resources[0] }}</p>
                                        <p>{{ __('crystal') }}: {{ $resources[1] }}</p>
                                        <p>{{ __('deuterium') }}: {{ $resources[2] }}</p>
                                    </div>
                                @endif
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
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
