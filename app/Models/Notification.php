<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'body', 'resources', 'defenses', 'solar_system_position', 'galaxy_position', 'type', 'totalLost'];

    public static function notificationAttack($resources, $defense, $coordinates, $totalLost)
    {
        return self::create([
            'user_id' => auth()->id(),
            'title' => 'notification_title_attack',
            'body' => 'notification_body_attack',
            'resources' => json_encode($resources),
            'defenses' => json_encode($defense),
            'solar_system_position' => $coordinates[0],
            'galaxy_position' => $coordinates[1],
            'type' => 'attack',
            'totalLost' => $totalLost
        ]);
    }

    public static function notificationSpy($resources, $defense, $coordinates)
    {
        return self::create([
            'user_id' => auth()->id(),
            'title' => 'notification_title_spy',
            'body' => 'notification_body_spy',
            'resources' => json_encode($resources),
            'defenses' => json_encode($defense),
            'solar_system_position' => $coordinates[0],
            'galaxy_position' => $coordinates[1],
            'type' => 'spy',
        ]);
    }

    public static function notificationExpedition($resources)
    {
        return self::create([
            'user_id' => auth()->id(),
            'title' => 'notification_title_expedition',
            'body' => 'notification_body_expedition',
            'resources' => json_encode($resources),
            'type' => 'expedition',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
