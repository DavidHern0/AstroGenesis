<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'body', 'parameters', 'type'];

    public static function spyNotification($userId, $otherPlanet)
    {
        return self::create([
            'user_id' => $userId,
            'title' => 'notification_title_spy',
            'body' => 'notification_body_spy',
            'parameters' => "['planetName' => $otherPlanet->name, 'planetSSP' => $otherPlanet->solay_system_position, 'planetGP' => $otherPlanet->galaxy_position]",
            'type' => 'spy',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
