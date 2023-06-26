<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Defense;
use App\Models\Planet;
use Illuminate\Support\Facades\Log;

class DefensePlanet extends Model
{
    use HasFactory;
    protected $fillable = ['defense_id', 'planet_id', 'quantity'];

    public static function createDefault($planetId)
    {
        $defenses = Defense::all();
        foreach ($defenses as $defense) { 
            self::create([
                'defense_id' => $defense->id,
                'planet_id' => $planetId,
                'quantity' => 0,
            ]);
        }
    }

    public function defense()
    {
        return $this->belongsTo(Defense::class);
    }
    
    public function planet()
    {
        return $this->belongsTo(Planet::class);
    }
}
