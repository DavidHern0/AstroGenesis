<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use App\Models\UserGame;
use App\Models\DefensePlanet;
use App\Models\DefenseLevel;
use Illuminate\Support\Facades\Log;

class ResourcesPlayersService
{
    public function updateAll()
    {
        $userGames = userGame::All();
        foreach ($userGames as $userGame) {
            $userID = $userGame->user_id;
            $planet = Planet::where('user_id', $userID)->first();
            $buildingPlanets = BuildingPlanet::where('planet_id', $planet->id)->get();
            $buildingLevels = BuildingLevel::all();

            $metal_mine = BuildingPlanet::where('building_id', 1)
                ->where('planet_id', $planet->id)->first();

            $crystal_mine = BuildingPlanet::where('building_id', 2)
                ->where('planet_id', $planet->id)->first();

            $deuterium_mine = BuildingPlanet::where('building_id', 3)
                ->where('planet_id', $planet->id)->first();

            $metal_production = BuildingLevel::where('building_id', 1)
                ->where('level', $metal_mine->level)
                ->pluck('production_rate')
                ->first();

            $crystal_production = BuildingLevel::where('building_id', 2)
                ->where('level', $crystal_mine->level)
                ->pluck('production_rate')
                ->first();

            $deuterium_production = BuildingLevel::where('building_id', 3)
                ->where('level', $deuterium_mine->level)
                ->pluck('production_rate')
                ->first();


            // BOOST ////////////////////////////////////////////////////////
            $metal_production *= env('BOOST');
            $crystal_production *= env('BOOST');
            $deuterium_production *= env('BOOST');
            /////////////////////////////////////////////////////////////////

            if ($userGame->energy < 0) {
                $metal_production *= 0.4;
                $crystal_production *= 0.4;
                $deuterium_production *= 0.4;
            }

            if ($userGame) {
                if ($metal_production) {
                    $metal_production_per_hour = ($metal_production + 40) / 3600;
                    if ($userGame->metal < $userGame->metal_storage) {
                        $userGame->metal += round($metal_production_per_hour * 60, 3);
                    } else {
                        $userGame->metal = $userGame->metal_storage;
                    }
                }
                if ($crystal_production) {
                    $crystal_production_per_hour = ($crystal_production + 15) / 3600;
                    if ($userGame->crystal < $userGame->crystal_storage) {
                        $userGame->crystal += round($crystal_production_per_hour * 60, 3);
                    } else {
                        $userGame->crystal = $userGame->crystal_storage;
                    }
                }
                if ($deuterium_mine->level != 0) {
                    $deuterium_production_per_hour = ($deuterium_production + 15) / 3600;
                    if ($userGame->deuterium < $userGame->deuterium_storage) {
                        $userGame->deuterium += round($deuterium_production_per_hour * 60, 3);
                    } else {
                        $userGame->deuterium = $userGame->deuterium_storage;
                    }
                }
                $userGame->save();
                // Log::info("userID:".$userGame->user_id . ", +metal:".round($metal_production_per_hour * 60, 3));
                // Log::info("userID:".$userGame->user_id . ", +crystal:".round($crystal_production_per_hour * 60, 3));
                // Log::info("userID:".$userGame->user_id . ", +deuterium:".round($deuterium_production_per_hour * 60, 3));
            }
        }
    }
}
