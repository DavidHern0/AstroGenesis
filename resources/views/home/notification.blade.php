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
                @endphp
                <div class="accordion-item">
                    <div class="accordion-header @if($notification->read == 0)unread @endif" data-notification-id="{{$notification->id}}">
                        <h3>{{__($notification->title)}} [{{$notification->solar_system_position}}:{{$notification->galaxy_position}}]:</h3>
                        <i class="fas fa-times" data-notification-id="{{$notification->id}}"></i>
                    </div>
                  <div class="accordion-content">
                      <h4>{{__($notification->body)}}:</h4>
                      <div class="accordion-resources">
                          <p>{{__('metal')}}: {{$resources[0]}}</p>
                          <p>{{__('crystal')}}: {{$resources[1]}}</p>
                          <p>{{__('deuterium')}}: {{$resources[2]}}</p>
                        </div>
                        <div class="accordion-defenses">
                            @foreach ($defensePlanets as $index => $defensePlanet)
                            @if ($index < $defensePlanetsCount && $index < count($defenses))
                            <p>{{$defensePlanet->defense->getTranslation('name', config('app.locale'))}}: {{$defenses[$index]}}</p>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection