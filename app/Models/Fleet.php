<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\ShipPlanet;

class fleet extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'departure', 'arrival', 'solar_system_position_departure', 'galaxy_position_departure', 'solar_system_position_arrival', 'galaxy_position_arrival', 'shipsSent'];


    public static function sendFleet($shipPlanet_ids, $ship_numbers, $otherPlanet)
    {
        $userID = auth()->id();
        $userPlanet = Planet::where('user_id', $userID)->first();
        $ssp_difference = abs($userPlanet->solar_system_position - $otherPlanet->solar_system_position);
        $gp_difference =  abs($userPlanet->galaxy_position - $otherPlanet->galaxy_position);

        $seconds_diff = $ssp_difference * 5 + $gp_difference * 30;
        $arrival = Carbon::now()->addSeconds($seconds_diff);
        $arrayShips = [];
        array_push($arrayShips, $shipPlanet_ids, $ship_numbers);

        return self::create([
            'user_id' => $userID,
            'arrival' => $arrival,
            'solar_system_position_departure' => $userPlanet->solar_system_position,
            'galaxy_position_departure' => $userPlanet->galaxy_position,
            'solar_system_position_arrival' => $otherPlanet->solar_system_position,
            'galaxy_position_arrival' => $otherPlanet->galaxy_position,
            'shipsSent' => json_encode($arrayShips)
        ]);
    }

    public static function expedition($shipPlanet_ids, $ship_numbers, $expedition_hours)
    {
        $userID = auth()->id();
        $userPlanet = Planet::where('user_id', $userID)->first();
        $arrival = Carbon::now()->addSeconds($expedition_hours * 3600);
        $arrayShips = [];
        array_push($arrayShips, $shipPlanet_ids, $ship_numbers);

        return self::create([
            'user_id' => $userID,
            'arrival' => $arrival,
            'solar_system_position_departure' => $userPlanet->solar_system_position,
            'galaxy_position_departure' => $userPlanet->galaxy_position,
            'shipsSent' => json_encode($arrayShips)
        ]);
    }

    public static function createSpy($otherPlanet)
    {
        $userID = auth()->id();

        $userPlanet = Planet::where('user_id', $userID)->first();
        $ssp_difference = abs($userPlanet->solar_system_position - $otherPlanet->solar_system_position);
        $gp_difference =  abs($userPlanet->galaxy_position - $otherPlanet->galaxy_position);

        $seconds_diff = $ssp_difference * 5 + $gp_difference * 30;
        $arrival = Carbon::now()->addSeconds($seconds_diff);

        return self::create([
            'user_id' => $userID,
            'arrival' => $arrival,
            'solar_system_position_arrival' => $otherPlanet->solar_system_position,
            'galaxy_position_arrival' => $otherPlanet->galaxy_position
        ]);
    }

    public static function recoverFromExpedition()
    {
        $userID = auth()->id();

        $userPlanet = Planet::where('user_id', $userID)->first();

        $lastFleet = Fleet::where('user_id', $userID)
            ->latest('created_at')
            ->first();

        $ships = json_decode($lastFleet->shipsSent);

        $shipsId = array_shift($ships);
        $quantity = array_pop($ships);

        foreach ($shipsId as $i => $shipId) {
            $shipPlanet = ShipPlanet::where('ship_id', $shipId)
                ->where('planet_id', $userPlanet->id)
                ->first();
            $shipPlanet->quantity += $quantity[$i];
            $shipPlanet->save();
        }
    }



    public static function calculateFleetAttack($shipPlanet_ids, $ship_numbers)
    {
        $attackPower = 0;

        foreach ($shipPlanet_ids as $i => $shipPlanet_id) {
            $shipLevel = ShipLevel::where('ship_id', $shipPlanet_id)->first();
            if ($shipLevel) {
                // Usamos 'construction_time' como proxy de fuerza de ataque
                $attackPower += $shipLevel->construction_time * $ship_numbers[$i];
            }
        }
        return $attackPower;
    }

    public static function calculatePlanetDefense($planet)
    {
        $defenses = DefensePlanet::where('planet_id', $planet->id)
            ->where('quantity', '>', 0)->get();
        $totalDefense = 0;

        foreach ($defenses as $defense) {

            $defensesLevel = DefenseLevel::where('defense_id', $defense->defense_id)->first();
            $totalDefense += $defensesLevel->construction_time * $defense->quantity;
        }
        return $totalDefense;
    }

    public static function attackPlanet($shipPlanet_ids, $ship_numbers, $otherPlanet)
    {
        $userID = auth()->id();
        $userPlanet = Planet::where('user_id', $userID)->first();
        $otherUserGame = userGame::where('user_id', $otherPlanet->user_id)->first();
        $otherPlanet = Planet::where('user_id', $otherPlanet->user_id)->first();

        $fleetAttack = self::calculateFleetAttack($shipPlanet_ids, $ship_numbers);
        $planetDefense = self::calculatePlanetDefense($otherPlanet);
        $ratio = ($planetDefense > 0) ? $fleetAttack / $planetDefense : 1;

        if ($fleetAttack > $planetDefense) {
            $attackSuccess = true;

            // Calcular capacidad total de carga de la flota
            $totalCargo = 0;
            foreach ($shipPlanet_ids as $i => $shipId) {
                $shipLevel = ShipLevel::where('ship_id', $shipId)->first();
                if ($shipLevel) {
                    $totalCargo += $shipLevel->cargo_capacity * $ship_numbers[$i];
                }
            }

            // Loot ratio según fuerza de ataque
            $lootRatio = 0.8;
            if ($ratio > 1) {
                $lootRatio = min(0.8, 1 - 0.8 * (1 / $ratio));
            }

            // Recursos "brutos" a robar
            $resourcesLootedRaw = [
                'metal' => round($otherUserGame->metal * $lootRatio),
                'crystal' => round($otherUserGame->crystal * $lootRatio),
                'deuterium' => round($otherUserGame->deuterium * $lootRatio),
            ];

            // Ajustar loot a la capacidad de la flota
            $totalResources = array_sum($resourcesLootedRaw);
            if ($totalResources > $totalCargo) {
                $scale = $totalCargo / $totalResources;
                $resourcesLooted = [
                    'metal' => floor($resourcesLootedRaw['metal'] * $scale),
                    'crystal' => floor($resourcesLootedRaw['crystal'] * $scale),
                    'deuterium' => floor($resourcesLootedRaw['deuterium'] * $scale),
                ];
            } else {
                $resourcesLooted = $resourcesLootedRaw;
            }
            
            $damageRatio = 1;
        } else {
            // Ataque fallido
            $attackSuccess = false;
            $resourcesLooted = [
                'metal' => 0,
                'crystal' => 0,
                'deuterium' => 0,
            ];
            $damageRatio = ($ratio / ($ratio + 3)) * 0.9;
        }
        // Destruir defensas
        $defenses = DefensePlanet::where('planet_id', $otherPlanet->id)->get();
        $destroyedDefenses = [];

        foreach ($defenses as $defense) {
            $destroyedQuantity = 0;
            if ($defense->quantity > 0) {
                for ($i = 0; $i < $defense->quantity; $i++) {
                    if (rand(0, 100) / 100 < $damageRatio) {
                        $destroyedQuantity++;
                    }
                }
                $defense->quantity = max($defense->quantity - $destroyedQuantity, 0);
                $defense->save();
            }
            $destroyedDefenses[] = $destroyedQuantity;
        }

        //Destruir naves
        $userFleet = Fleet::where('user_id', $userID)
            ->latest('created_at')
            ->first();
        if ($userFleet) {
            $newQuantities = $ship_numbers;

            $lossRatio = 1 / (1 + pow($ratio, 5));
            foreach ($newQuantities as $i => $qty) {
                $lost = $qty * $lossRatio;
                $newQuantities[$i] = max(0, $qty - $lost);
                $shipPlanetId = $shipPlanet_ids[$i];
                if ($lost > 0) {
                    $shipLevel = ShipLevel::where('ship_id', $shipPlanetId)->first();

                    $shipValue = round($lost) * (0.01 + mt_rand() / mt_getrandmax() * (0.05 - 0.01)); //random entre 0,01 y 0,05
                    $otherUserGame->metal += $shipValue * $shipLevel->metal_cost;
                    $otherUserGame->crystal += $shipValue * $shipLevel->crystal_cost;
                    $otherUserGame->deuterium += $shipValue * $shipLevel->deuterium_cost;
                }
            }
            $otherUserGame->save();


            // Guardar cantidades actualizadas
            $userFleet->shipsSent = json_encode([$shipPlanet_ids, $newQuantities]);
            $userFleet->save();
            $ship_numbers = $newQuantities;
        }
        // Guardar info en session
        session([
            'resourcesLooted' => $resourcesLooted,
            'destroyedDefenses' => $destroyedDefenses,
            'otherPlanetID' => $otherPlanet->user_id,
            'fleetAttack' => $fleetAttack,
            'planetDefense' => $planetDefense,
        ]);

        // Crear registro de flota
        $ssp_difference = abs($userPlanet->solar_system_position - $otherPlanet->solar_system_position);
        $gp_difference = abs($userPlanet->galaxy_position - $otherPlanet->galaxy_position);
        $seconds_diff = $ssp_difference * 5 + $gp_difference * 30;
        $arrival = Carbon::now()->addSeconds($seconds_diff);

        return self::create([
            'user_id' => $userID,
            'arrival' => $arrival,
            'solar_system_position_departure' => $userPlanet->solar_system_position,
            'galaxy_position_departure' => $userPlanet->galaxy_position,
            'shipsSent' => json_encode([$shipPlanet_ids, $ship_numbers]),
            'success' => $attackSuccess ? 100 : 0
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
