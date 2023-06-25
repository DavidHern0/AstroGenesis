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
    
        $resourcesBuildingIds = [1, 2, 3, 4, 5, 6, 7];

        foreach ($buildings as $building) { 
            $type = in_array($building->id, $resourcesBuildingIds) ? "resources" : "facilities";
            self::create([
                'building_id' => $building->id,
                'planet_id' => $planetId,
                'level' => 0,
                'type' => $type
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
