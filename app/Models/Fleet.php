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
        $arrival = Carbon::now()->addSeconds($expedition_hours*3600);
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
