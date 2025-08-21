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
        if (!$userGame) {
            Log::channel('cpuinfo')->warning("Planeta CPU: {$planet->id} no tiene un UserGame asociado. build() abortado.");
            return;
        }

        $buildings = BuildingPlanet::where('planet_id', $planet->id)
            ->where('type', 'resources')
            ->get();

        $metalMine = $buildings->where('building_id', 1)->first();
        $crystalMine = $buildings->where('building_id', 2)->first();
        $deuteriumMine = $buildings->where('building_id', 3)->first();
        $metalStorage = $buildings->where('building_id', 5)->first();
        $crystalStorage = $buildings->where('building_id', 6)->first();
        $deuteriumStorage = $buildings->where('building_id', 7)->first();

        // 1. Construir almacenes si recursos > 80%
        if ($metalStorage && $userGame->metal / $userGame->metal_storage > 0.8) {
            if ($this->canBuild($planet, $metalStorage, $userGame)) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} mejorando almacén de metal (nivel anterior: {$metalStorage->level})");
                $this->constructBuilding($planet, $metalStorage, $userGame);
                return;
            }
        }

        if ($crystalStorage && $userGame->crystal / $userGame->crystal_storage > 0.8) {
            if ($this->canBuild($planet, $crystalStorage, $userGame)) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} mejorando almacén de cristal (nivel anterior: {$crystalStorage->level})");
                $this->constructBuilding($planet, $crystalStorage, $userGame);
                return;
            }
        }

        if ($deuteriumStorage && $userGame->deuterium / $userGame->deuterium_storage > 0.8) {
            if ($this->canBuild($planet, $deuteriumStorage, $userGame)) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} mejorando almacén de deuterio (nivel anterior: {$deuteriumStorage->level})");
                $this->constructBuilding($planet, $deuteriumStorage, $userGame);
                return;
            }
        }

        // 2. Construir defensas si mina de metal >= 8
        if ($metalMine && $metalMine->level >= 8) {
            $this->maybeConstructDefenses($planet, $userGame);
        }

        // 3. INACTIVIDAD
        $inactivityChance = 0;
        if ($metalMine) {
            $inactivityChance = rand(1, 10);
            if ($metalMine->level >= 12) {
                $inactivityChance = min(95, ($metalMine->level / 12) * 95);
            } else if ($metalMine->level >= 8) {
                $inactivityChance = min(90, ($metalMine->level / 8) * 90);
            } else if ($metalMine->level >= 5) {
                $inactivityChance = min(50, ($metalMine->level / 5) * 50);
            }
        }
        if (rand(1, 100) <= $inactivityChance) {
            Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} INACTIVO. Probabilidad: {$inactivityChance}%");
            return;
        }

        // 4. Prioridad: mina de metal
        if ($metalMine && $this->canBuild($planet, $metalMine, $userGame)) {
            Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} mejorando mina de metal (nivel anterior: {$metalMine->level})");
            $this->constructBuilding($planet, $metalMine, $userGame);
        }

        // 5. Equilibrar minas de cristal y deuterio
        if ($crystalMine && $metalMine && ($metalMine->level - $crystalMine->level > 2)) {
            if ($this->canBuild($planet, $crystalMine, $userGame)) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} equilibrando minas: mejorando mina de cristal (nivel anterior: {$crystalMine->level})");
                $this->constructBuilding($planet, $crystalMine, $userGame);
                return;
            } else {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} no hay recursos suficientes para mina de cristal.");
            }
        }

        if ($deuteriumMine && $metalMine && ($metalMine->level - $deuteriumMine->level > 4)) {
            if ($this->canBuild($planet, $deuteriumMine, $userGame)) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} equilibrando minas: mejorando mina de deuterio (nivel anterior: {$deuteriumMine->level})");
                $this->constructBuilding($planet, $deuteriumMine, $userGame);
                return;
            } else {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} no hay recursos suficientes para mina de deuterio.");
            }
        }

        // 6. Construir cualquier otro edificio normal
        foreach ($buildings as $building) {
            if ($building->building_id == 1 || $building->building_id == 2 || $building->building_id == 3) continue;
            if ($this->canBuild($planet, $building, $userGame)) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} mejorando edificio {$building->building_id} (nivel anterior: {$building->level})");
                $this->constructBuilding($planet, $building, $userGame);
                return;
            }
        }

        Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} no construye este turno.");
    }

    protected function canBuild(Planet $planet, BuildingPlanet $building, UserGame $userGame)
    {
        $nextLevel = $building->level + 1;
        $cost = BuildingLevel::where('building_id', $building->building_id)
            ->where('level', $nextLevel)
            ->first();

        if (!$cost) {
            Log::channel('cpuinfo')->warning("Planeta CPU: {$planet->id} no existe costo para la construcción {$building->building_id} nivel {$nextLevel}");
            return false;
        }

        $canBuild = $userGame->metal >= $cost->metal_cost
            && $userGame->crystal >= $cost->crystal_cost
            && $userGame->deuterium >= $cost->deuterium_cost;

        if ($building->building_id != 4) {
            $canBuild = $canBuild && $userGame->energy >= $cost->energy_cost;
        }

        if (!$canBuild) {
            if (
                $userGame->metal < $cost->metal_cost ||
                $userGame->crystal < $cost->crystal_cost ||
                $userGame->deuterium < $cost->deuterium_cost
            ) {
                Log::channel('cpuinfo')->debug("Planeta CPU: {$planet->id} no tiene recursos para {$building->building_id} nivel {$nextLevel}");
            } elseif ($building->building_id != 4 && $userGame->energy < $cost->energy_cost) {
                Log::channel('cpuinfo')->debug("Planeta CPU: {$planet->id} no tiene energía suficiente para {$building->building_id} nivel {$nextLevel}");
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

        if ($building->building_id == 5) $userGame->metal_storage = $cost->production_rate;
        if ($building->building_id == 6) $userGame->crystal_storage = $cost->production_rate;
        if ($building->building_id == 7) $userGame->deuterium_storage = $cost->production_rate;

        $building->level = $nextLevel;
        $building->save();
        $userGame->save();
    }

    protected function maybeConstructDefenses(Planet $planet, UserGame $userGame)
    {
        $metalMine = BuildingPlanet::where('planet_id', $planet->id)
            ->where('building_id', 1)
            ->first();
        $mineLevel = $metalMine ? $metalMine->level : 1;

        $chance = min(90, 30 + ($mineLevel * 5));

        $hasDefenses = DefensePlanet::where('planet_id', $planet->id)
            ->where('quantity', '>', 0)
            ->exists();

        if ($hasDefenses) {
            $inactivityChance = min(80, ($mineLevel / 10) * 80);
            if (rand(1, 100) <= $inactivityChance) {
                Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} defensas existentes. INACTIVO en construcción de defensas (Prob: {$inactivityChance}%)");
                return;
            }
        }

        if (rand(1, 100) <= $chance) {
            Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} - Probabilidad de construir defensas: {$chance}% - SE construirá");
            $this->constructDefenses($planet, $userGame);
        } else {
            Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} - Probabilidad de construir defensas: {" . (100 - $chance) . "}% - NO se construirá");
        }
    }

    protected function constructDefenses(Planet $planet, UserGame $userGame)
    {
        $reserveFactor = rand(20, 40) / 100;
        $costFactor = 0.5;

        $availableMetal = $userGame->metal * (1 - $reserveFactor);
        $availableCrystal = $userGame->crystal * (1 - $reserveFactor);
        $availableDeuterium = $userGame->deuterium * (1 - $reserveFactor);

        $builtCount = 0;

        // 🎲 Elegir SOLO un tipo de defensa aleatorio (1 a 8)
        $defenseId = rand(1, 8);
        $levelCost = DefenseLevel::where('defense_id', $defenseId)->orderBy('id')->first();
        if (!$levelCost) return;

        // Determinar batch máximo
        $isCheap = (
            $levelCost->metal_cost <= 10000 &&
            $levelCost->crystal_cost <= 10000 &&
            $levelCost->deuterium_cost <= 5000
        );

        $resourcePool = $availableMetal + $availableCrystal + $availableDeuterium;

        $maxBatch = $isCheap
            ? rand(3, min(20, intval($resourcePool / max(1000, ($levelCost->metal_cost + $levelCost->crystal_cost + $levelCost->deuterium_cost)))))
            : rand(1, 3);

        $currentBuilt = 0;
        while (
            $currentBuilt < $maxBatch &&
            $availableMetal >= $levelCost->metal_cost * $costFactor &&
            $availableCrystal >= $levelCost->crystal_cost * $costFactor &&
            $availableDeuterium >= $levelCost->deuterium_cost * $costFactor
        ) {
            // Restar recursos disponibles
            $availableMetal -= $levelCost->metal_cost * $costFactor;
            $availableCrystal -= $levelCost->crystal_cost * $costFactor;
            $availableDeuterium -= $levelCost->deuterium_cost * $costFactor;

            // Restar recursos del jugador
            $userGame->metal -= $levelCost->metal_cost * $costFactor;
            $userGame->crystal -= $levelCost->crystal_cost * $costFactor;
            $userGame->deuterium -= $levelCost->deuterium_cost * $costFactor;

            // Crear o actualizar defensa
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

        if ($builtCount > 0) {
            Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} construyó {$builtCount} defensas tipo {$defenseId} (Reserva: " . ($reserveFactor * 100) . "%)");
        } else {
            Log::channel('cpuinfo')->info("Planeta CPU: {$planet->id} no pudo construir defensas (recursos insuficientes o batch limitado: {$maxBatch})");
        }
    }
}
