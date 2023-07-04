<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'body', 'resources', 'defenses', 'solar_system_position', 'galaxy_position', 'type'];

    public static function notificationSpy($resources, $defense, $coordinates)
    {
        return self::create([
            'user_id' => auth()->id(),
            'title' => 'notification_title_spy',
            'body' => 'notification_body_spy',
            'resources' => json_encode($resources),
            'defenses' => json_encode($defense),
            'solar_system_position' => $coordinates[1],
            'galaxy_position' => $coordinates[0],
            'type' => 'spy',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
