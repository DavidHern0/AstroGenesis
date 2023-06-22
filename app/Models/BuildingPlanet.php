<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Building;

class BuildingPlanet extends Model
{
    use HasFactory;
    protected $fillable = ['building_id', 'planet_id', 'level'];

    public static function createDefault($planetId)
    {
        $buildings = Building::all();
        // $defaultLevel = [1, 2, 4, 5, 7];
    
        foreach ($buildings as $building) {
            // $level = in_array($building->id, $defaultLevel) ? 1 : 0;
    
            self::create([
                'building_id' => $building->id,
                'planet_id' => $planetId,
                'level' => 0
            ]);
        }
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    
    public function planet()
    {
        return $this->belongsTo(Planet::class);
    }
}
