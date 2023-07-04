<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Notification;

class Spy extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'departure', 'arrival', 'solar_system_position', 'galaxy_position'];

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
            'solar_system_position' => $otherPlanet->solar_system_position,
            'galaxy_position' => $otherPlanet->galaxy_position
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
