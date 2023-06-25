<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Planet extends Model
{
    protected $fillable = ['user_id', 'name', 'type', 'position', 'info'];

    /**
     * Crea un objeto Planet con valores por defecto.
     *
     * @param int $userId
     * @return Planet
     */
    public static function createDefault($userId)
    {
    
        if (App::getLocale() == 'es') {
            $planetName = 'Planeta Principal';
        } else if (App::getLocale() == 'en') {
            $planetName = 'Main Planet';
        } else {
            $planetName = 'Planet';
        }
    
        $randomVariation = rand(1, 10);
        $randomSSP = 0;
        $randomG = 0;
        $biome = '';
    
        do {
            $randomSSP = rand(1, env('RANDOM_SSP_MAX'));
            $randomG = rand(1, env('RANDOM_G_MAX'));
            $checkPosition = self::where('solar_system_position', $randomSSP)->where('galaxy_position', $randomG)->exists();            
        } while ($checkPosition);
        
        if ($randomSSP == 1) {
            $biome = "dry";
        } else if ($randomSSP >= 2 && $randomSSP <= 3) {
            $biomeOptions = ["dry", "desert"];
            $biome = $biomeOptions[rand(0, 1)];
        } else if ($randomSSP >= 4 && $randomSSP <= 5) {
            $biomeOptions = ["desert", "savanna"];
            $biome = $biomeOptions[rand(0, 1)];
        } else if ($randomSSP >= 6 && $randomSSP <= 9) {
            $biomeOptions = ["savanna", "jungle", "water"];
            $biome = $biomeOptions[rand(0, 2)];
        } else {
            $biome = 'ice';
        }
        
        if (rand(1, 12) === 1) {
            $biome = 'gas';
        }
    
        return self::create([
            'user_id' => $userId,
            'name' => $planetName,
            'type' => 'planet',
            'biome' => $biome,
            'variation' => $randomVariation,
            'solar_system_position' => $randomSSP,
            'galaxy_position' => $randomG,
            'info' => ''
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
