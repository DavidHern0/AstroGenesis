<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use App\Models\UserGame;
use App\Models\DefensePlanet;
use App\Models\DefenseLevel;
use Illuminate\Support\Facades\Log;

//Log::info("PlanetID: " . $planet->id . " no ha mejorado nada");
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

        // no más de 3 niveles de diferencia entre METAL y CRISTAL
        if ($building->building_id == 1 || $building->building_id == 2) {
            $metalMine   = BuildingPlanet::where('planet_id', $planet->id)->where('building_id', 1)->first();
            $crystalMine = BuildingPlanet::where('planet_id', $planet->id)->where('building_id', 2)->first();

            if ($metalMine && $crystalMine && abs($metalMine->level - $crystalMine->level) >= 3) {
                // Solo se permite construir si ayuda a equilibrar
                if ($building->building_id == 1 && $metalMine->level > $crystalMine->level) {
                    return false;
                }
                if ($building->building_id == 2 && $crystalMine->level > $metalMine->level) {
                    return false;
                }
            }
        }

        // no más de 3 niveles de diferencia entre CRISTAL y DEUTERIO
        if ($building->building_id == 2 || $building->building_id == 3) {
            $crystalMine   = BuildingPlanet::where('planet_id', $planet->id)->where('building_id', 2)->first();
            $deuteriumMine = BuildingPlanet::where('planet_id', $planet->id)->where('building_id', 3)->first();

            if ($crystalMine && $deuteriumMine && abs($crystalMine->level - $deuteriumMine->level) >= 3) {
                // Solo se permite construir si ayuda a equilibrar
                if ($building->building_id == 2 && $crystalMine->level > $deuteriumMine->level) {
                    return false;
                }
                if ($building->building_id == 3 && $deuteriumMine->level > $crystalMine->level) {
                    return false;
                }
            }
        }

        // Metal Mine (id 1) requiere Metal Storage (id 5) mínimo lvl2 si ya está lvl5+
        if ($building->building_id == 1 && $building->level >= 5) {
            $metalStorage = BuildingPlanet::where('planet_id', $planet->id)
                ->where('building_id', 5)
                ->first();
            if ($metalStorage && $metalStorage->level < 2) {
                return false;
            }
        }

        // Crystal Mine (id 2) requiere Crystal Storage (id 6) mínimo lvl2 si ya está lvl5+
        if ($building->building_id == 2 && $building->level >= 5) {
            $crystalStorage = BuildingPlanet::where('planet_id', $planet->id)
                ->where('building_id', 6)
                ->first();
            if ($crystalStorage && $crystalStorage->level < 2) {
                return false;
            }
        }

        // Deuterium Synthesizer (id 3) requiere Deuterium Storage (id 7) mínimo lvl2 si ya está lvl5+
        if ($building->building_id == 3 && $building->level >= 5) {
            $deuteriumStorage = BuildingPlanet::where('planet_id', $planet->id)
                ->where('building_id', 7)
                ->first();
            if ($deuteriumStorage && $deuteriumStorage->level < 2) {
                return false;
            }
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

        if ($building->building_id == 5) {
            $userGame->metal_storage += $cost->production_rate;
            Log::info("userGame->metal_storage" . $userGame->metal_storage);
        } else if ($building->building_id == 6) {
            $userGame->crystal_storage += $cost->production_rate;
            Log::info("userGame->crystal_storage" . $userGame->crystal_storage);
        } else if ($building->building_id == 7) {
            $userGame->deuterium_storage += $cost->production_rate;
            Log::info("userGame->deuterium_storage" . $userGame->deuterium_storage);
        }

        $building->level = $nextLevel;
        $building->save();
        $userGame->save();
        Log::info("PlanetID: " . $planet->id . " ha mejorado la mina " . $building->building_id . " a nivel " . $building->level);
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
        Log::info("PlanetID: " . $planet->id . "  ha mejorado la defensa " . $defense->defense_id . "(x" . $defense->quantity . ")");
    }
}
