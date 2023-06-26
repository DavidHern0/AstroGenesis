<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DefenseLevel extends Model
{
    use HasFactory;
        protected $fillable = [
        'defense_id',
        'metal_cost',
        'crystal_cost',
        'deuterium_cost',
    ];
}