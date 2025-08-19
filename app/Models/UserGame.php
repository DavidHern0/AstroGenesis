<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'metal', 'crystal', 'deuterium'];

    public static function createDefault($userId)
    {

        if ($userId != 1 && $userId <= (env('NUM_BOTS') + 1)) {
            return self::create([
                'user_id' => $userId,
                'metal' => rand(500, 40000),
                'crystal' => rand(300, 25000),
                'deuterium' => rand(200, 7500)
            ]);
        } else {
            return self::create([
                'user_id' => $userId
            ]);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
