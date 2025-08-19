<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use App\Models\UserGame;
use App\Models\DefensePlanet;
use App\Models\DefenseLevel;

class NpcConstructionService
{
    public function build(Planet $planet)
    {
        $userGame = UserGame::where('user_id', $planet->user_id)->first();
        if (!$userGame) return;

        $buildings = BuildingPlanet::where('planet_id', $planet->id)->get();

        foreach ($buildings as $building) {
            if ($this->canBuild($planet, $building, $userGame)) {
                $this->constructBuilding($planet, $building, $userGame);

                // Si la mina de metal alcanzó nivel 8 o más, construimos defensas
                if ($building->building_id == 1 && $building->level >= 8) {
                    // 80% de probabilidad de construir defensas
                    if (rand(1, 100) <= 80) {
                        $this->constructDefenses($planet, $userGame);
                    }
                }
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

        if ($building->building_id != 4) {
            $canBuild = $canBuild && $userGame->energy >= $cost->energy_cost;
        }

        return $canBuild;
    }

    protected function constructBuilding(Planet $planet, BuildingPlanet $building, UserGame $userGame)
    {
        $nextLevel = $building->level + 1;
        $cost = BuildingLevel::where('building_id', $building->building_id)
            ->where('level', $nextLevel)
            ->first();
        if (!$cost) return;

        $userGame->metal -= $cost->metal_cost;
        $userGame->crystal -= $cost->crystal_cost;
        $userGame->deuterium -= $cost->deuterium_cost;

        if ($building->building_id != 4) {
            $userGame->energy -= $cost->energy_cost;
        } else {
            $userGame->energy += $cost->production_rate;
        }

        $building->level = $nextLevel;
        $building->save();
        $userGame->save();
    }

    protected function constructDefenses(Planet $planet, UserGame $userGame)
    {
        // Solo defensas con defense_id 1 a 5
        $defenseIds = range(1, 5);

        foreach ($defenseIds as $defenseId) {
            // Obtenemos el primer nivel de esta defensa
            $levelCost = DefenseLevel::where('defense_id', $defenseId)->orderBy('id')->first();
            if (!$levelCost) continue;

            // Mientras haya recursos suficientes, construimos
            while (
                $userGame->metal >= $levelCost->metal_cost &&
                $userGame->crystal >= $levelCost->crystal_cost &&
                $userGame->deuterium >= $levelCost->deuterium_cost
            ) {
                // Restamos los recursos
                $userGame->metal -= $levelCost->metal_cost;
                $userGame->crystal -= $levelCost->crystal_cost;
                $userGame->deuterium -= $levelCost->deuterium_cost;

                // Si ya tiene esta defensa, sumamos cantidad
                $defense = DefensePlanet::firstOrCreate(
                    ['planet_id' => $planet->id, 'defense_id' => $defenseId],
                    ['quantity' => 0]
                );

                $defense->quantity += 1; // aumentamos en 1 unidad
                $defense->save();
                $userGame->save();
            }
        }
    }
}
