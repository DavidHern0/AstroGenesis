<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use App\Models\UserGame;
use Illuminate\Support\Facades\Log;

class NpcConstructionService
{
    public function build(Planet $planet)
    {
        $userGame = UserGame::where('user_id', $planet->user_id)->first();

        if (!$userGame) {
            return;
        }

        $buildings = BuildingPlanet::where('planet_id', $planet->id)->get();

        foreach ($buildings as $building) {
            if ($this->canBuild($planet, $building, $userGame)) {
                $this->construct($planet, $building, $userGame);
                break; // solo construimos un edificio por evaluación
            }
        }
    }

    protected function canBuild(Planet $planet, BuildingPlanet $building, UserGame $userGame)
    {
        $nextLevel = $building->level + 1;
        $cost = BuildingLevel::where('building_id', $building->building_id)
            ->where('level', $nextLevel)
            ->first();

        if (!$cost) return false;

        $canBuild = $userGame->metal >= $cost->metal_cost
            && $userGame->crystal >= $cost->crystal_cost
            && $userGame->deuterium >= $cost->deuterium_cost;

        // Siempre permitir construir building_id=4 aunque falte energía
        if ($building->building_id != 4) {
            $canBuild = $canBuild && $userGame->energy >= $cost->energy_cost;
        }

        return $canBuild;
    }

    protected function construct(Planet $planet, BuildingPlanet $building, UserGame $userGame)
    {
        $nextLevel = $building->level + 1;

        $cost = BuildingLevel::where('building_id', $building->building_id)
            ->where('level', $nextLevel)
            ->first();

        if (!$cost) return;

        // Actualizamos recursos
        $userGame->metal -= $cost->metal_cost;
        $userGame->crystal -= $cost->crystal_cost;
        $userGame->deuterium -= $cost->deuterium_cost;

        if ($building->building_id != 4) {
            $userGame->energy -= $cost->energy_cost;
        } else {
            // Si es building 4, sumamos energía según production_rate
            $userGame->energy += $cost->production_rate;
        }

        $building->level = $nextLevel;
        $building->save();
        $userGame->save();


        Log::info("PlanetID: " . $planet->id . " has upgraded mine " . $building->building_id);
    }
}
