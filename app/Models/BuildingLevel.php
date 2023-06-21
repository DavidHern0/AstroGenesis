<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingLevel extends Model
{
    use HasFactory;
        protected $fillable = [
        'building_id',
        'level',
        'metal_cost',
        'crystal_cost',
        'deuterium_cost',
        'energy_cost',
        'production_rate',
        'resource_type',
    ];
}
