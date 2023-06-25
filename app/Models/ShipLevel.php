<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ShipLevel extends Model
{
    use HasFactory;
        protected $fillable = [
        'ship_id',
        'metal_cost',
        'crystal_cost',
        'deuterium_cost',
    ];
}