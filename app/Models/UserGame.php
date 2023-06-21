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

        return self::create([
            'user_id' => $userId
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
