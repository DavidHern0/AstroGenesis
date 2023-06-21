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
        
        if (App::getLocale() == 'es') {
            $planetName = 'Planeta Principal';
        } else if (App::getLocale() == 'en') {
            $planetName = 'Main Planet';
        } else {
            $planetName = 'Planet';
        }

        return self::create([
            'user_id' => $userId,
            'name' => $planetName,
            'type' => 'planet',
            'position' => '',
            'info' => ''
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}