<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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
        $biomes = ['desert', 'dry', 'gas', 'ice', 'savanna', 'jungle', 'water'];
    
        if (App::getLocale() == 'es') {
            $planetName = 'Planeta Principal';
        } else if (App::getLocale() == 'en') {
            $planetName = 'Main Planet';
        } else {
            $planetName = 'Planet';
        }
    
        $biome = $biomes[array_rand($biomes)];
        $randomVariation = rand(1, 10);
    
        return self::create([
            'user_id' => $userId,
            'name' => $planetName,
            'type' => 'planet',
            'biome' => $biome,
            'variation' => $randomVariation,
            'position' => '',
            'info' => ''
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
