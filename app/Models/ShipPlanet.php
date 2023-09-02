<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ship;
use App\Models\Planet;
use Illuminate\Support\Facades\Log;

class ShipPlanet extends Model
{
    use HasFactory;
    protected $fillable = ['ship_id', 'planet_id', 'quantity'];

    public static function createDefault($planetId)
    {
        $ships = Ship::all();
        foreach ($ships as $ship) { 
            self::create([
                'ship_id' => $ship->id,
                'planet_id' => $planetId,
                'quantity' => 0,
            ]);
        }
    }
    
    public static function subtractShipsSent($shipPlanet_ids, $ship_numbers)
    {
        $userID = auth()->id();
        $planet = Planet::where('user_id', $userID)->first();
        $allShips = [];
        foreach ($shipPlanet_ids as $i => $shipPlanet_id) {
            $ship = ShipPlanet::where('planet_id', $planet->id)->where('ship_id', $shipPlanet_id)->first();
            $ship->quantity -= $ship_numbers[$i];
            $ship->save();
        }
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
    
    public function planet()
    {
        return $this->belongsTo(Planet::class);
    }
}
