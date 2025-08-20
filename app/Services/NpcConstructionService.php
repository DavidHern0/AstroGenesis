<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use App\Models\UserGame;
use App\Models\DefensePlanet;
use App\Models\DefenseLevel;
use Illuminate\Support\Facades\Log;

class NpcConstructionService
{
    public function build(Planet $planet)
    {
        $userGame = UserGame::where('user_id', $planet->user_id)->first();
        if (!$userGame) return;

        $buildings = BuildingPlanet::where('planet_id', $planet->id)->get();

        $metalMine = BuildingPlanet::where('planet_id', $planet->id)
            ->where("building_id", 1)->first();

        if ($metalMine->level >= 8) {
            if (rand(1, 100) <= 90) {
                Log::info("PlanetID: " . $planet->id . " está inactivo en este ciclo.");
                return;
            }
        }


        foreach ($buildings as $building) {
            if ($this->canBuild($planet, $building, $userGame)) {
                $this->constructBuilding($planet, $building, $userGame);

                // Evaluamos defensas solo si mina de metal >= 8
                if ($building->building_id == 1 && $building->level >= 8) {
                    $this->maybeConstructDefenses($planet, $userGame);
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

        // Manejo de almacenes
        if ($building->building_id == 5) {
            $userGame->metal_storage += $cost->production_rate;
        } else if ($building->building_id == 6) {
            $userGame->crystal_storage += $cost->production_rate;
        } else if ($building->building_id == 7) {
            $userGame->deuterium_storage += $cost->production_rate;
        }

        $building->level = $nextLevel;
        $building->save();
        $userGame->save();

        Log::info("PlanetID: " . $planet->id . " ha mejorado la construcción " . $building->building_id . " a nivel " . $building->level);
    }

    /**
     * Decide si se construyen defensas en base a nivel de minas
     */
    protected function maybeConstructDefenses(Planet $planet, UserGame $userGame)
    {
        $metalMine = BuildingPlanet::where('planet_id', $planet->id)
            ->where('building_id', 1) // mina de metal
            ->first();

        $mineLevel = $metalMine ? $metalMine->level : 1;

        // Probabilidad de construir defensas: 30% base + 5% por nivel de mina (máx. 90%)
        $chance = min(90, 30 + ($mineLevel * 5));

        // Verificamos si ya tienen defensas
        $hasDefenses = DefensePlanet::where('planet_id', $planet->id)
            ->where('quantity', '>', 0)
            ->exists();

        if ($hasDefenses) {
            // A más nivel de mina, más chance de inactividad
            // Escala: lvl 1 = 8%, lvl 5 = 40%, lvl 10+ = 80%
            $inactivityChance = min(80, ($mineLevel / 10) * 80);

            if (rand(1, 100) <= $inactivityChance) {
                Log::info("PlanetID: " . $planet->id . " decidió estar inactivo este turno. (Mina $mineLevel, Inactividad $inactivityChance%)");
                return;
            }
        }

        if (rand(1, 100) <= $chance) {
            $this->constructDefenses($planet, $userGame);
        } else {
            Log::info("PlanetID: " . $planet->id . " no construyó defensas este turno. (Chance $chance%)");
        }
    }



    /**
     * Construcción de defensas con batch limitado, chance dinámica y ahorro de recursos
     */
    protected function constructDefenses(Planet $planet, UserGame $userGame)
    {
        // Factor de ahorro aleatorio entre 20% y 40%
        $reserveFactor = rand(20, 40) / 100;

        // Factor de costo reducido: NPCs pagan solo la mitad
        $costFactor = 0.5;

        $availableMetal = $userGame->metal * (1 - $reserveFactor);
        $availableCrystal = $userGame->crystal * (1 - $reserveFactor);
        $availableDeuterium = $userGame->deuterium * (1 - $reserveFactor);

        $builtCount = 0;
        $defenseIds = range(1, 8);
        shuffle($defenseIds);

        foreach ($defenseIds as $defenseId) {
            $levelCost = DefenseLevel::where('defense_id', $defenseId)->orderBy('id')->first();
            if (!$levelCost) continue;

            // Clasificación barato/caro según costes
            $isCheap = (
                $levelCost->metal_cost <= 10000 &&
                $levelCost->crystal_cost <= 10000 &&
                $levelCost->deuterium_cost <= 5000
            );

            if ($isCheap) {
                // Baratos: batch dinámico según recursos
                $totalResources = $availableMetal + $availableCrystal + $availableDeuterium;
                $maxBatch = min(20, max(1, intval($totalResources / 20000)));
            } else {
                // Caros: batch pequeño
                $maxBatch = rand(1, 3);
            }

            $currentBuilt = 0;

            while (
                $currentBuilt < $maxBatch &&
                $availableMetal >= $levelCost->metal_cost * $costFactor &&
                $availableCrystal >= $levelCost->crystal_cost * $costFactor &&
                $availableDeuterium >= $levelCost->deuterium_cost * $costFactor
            ) {
                // Restamos de los recursos disponibles
                $availableMetal -= $levelCost->metal_cost * $costFactor;
                $availableCrystal -= $levelCost->crystal_cost * $costFactor;
                $availableDeuterium -= $levelCost->deuterium_cost * $costFactor;

                // Restamos del UserGame real (solo mitad del costo)
                $userGame->metal -= $levelCost->metal_cost * $costFactor;
                $userGame->crystal -= $levelCost->crystal_cost * $costFactor;
                $userGame->deuterium -= $levelCost->deuterium_cost * $costFactor;

                // Creamos o sumamos la defensa
                $defense = DefensePlanet::firstOrCreate(
                    ['planet_id' => $planet->id, 'defense_id' => $defenseId],
                    ['quantity' => 0]
                );

                $defense->quantity += 1;
                $defense->save();
                $userGame->save();

                $builtCount++;
                $currentBuilt++;
            }
        }

        if ($builtCount > 0) {
            Log::info("PlanetID: " . $planet->id . " construyó $builtCount defensas en este ciclo (ID:" . $defense->defense_id . "), Reserva: " . ($reserveFactor * 100) . "%)");
        }
    }
}
