<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $universe_acceleration_factor = 1;
        
        //Metal mine
        for ($i=1; $i <= 50; $i++) { 
            // $production = round(30 * $universe_acceleration_factor * $i+1 * (1.1 ** $i));
            $energy_cost = round(10 * $i * (1.1 ** $i));
            $base_cost = [60, 15];
            $metal_cost = round($base_cost[0] * (1.5 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (1.5 ** ($i-1)));
            $production = round(30 * $universe_acceleration_factor * $i * (1.1 ** $i) + 30 * $universe_acceleration_factor);
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 1,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'metal',
                'construction_time' => $construction_time
            ]);
        }

        //Crystal mine
        for ($i=1; $i <= 50; $i++) { 
            // $production = round(20 * $universe_acceleration_factor * $i+1 * (1.1 ** $i));
            $energy_cost = round(10 * $i * (1.1 ** $i));
            $base_cost = [48, 24];
            $metal_cost = round($base_cost[0] * (1.6 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (1.6 ** ($i-1)));
            $production = round($universe_acceleration_factor * 20 * $i* (1.1 ** $i));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 2,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'crystal',
                'construction_time' => $construction_time
            ]);
        }

        $temp = 20;
        //Deuterium mine
        for ($i=1; $i <= 50; $i++) { 
            $energy_cost = round(20 * $i * (1.1 ** $i));
            $base_cost = [225, 75];
            $metal_cost = round($base_cost[0] * (1.5 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (1.5 ** ($i-1)));
            $production = round($universe_acceleration_factor * $energy_cost * (0.68 - 0.002 * $temp));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 3,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'deuterium',
                'construction_time' => $construction_time
            ]);
        }

        //Solar panel
        for ($i=1; $i <= 50; $i++) { 
            $energy_cost = 0;
            $base_cost = [75, 30];
            $metal_cost = round($base_cost[0] * (1.5 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (1.5 ** ($i-1)));
            $production = round(20 * $i * (1.1 ** $i));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 4,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'energy',
                'construction_time' => $construction_time
            ]);
        }

        //Metal storage
        for ($i=1; $i <= 50; $i++) { 
            $energy_cost = 0;
            $base_cost = [1000, 0];
            $metal_cost = round($base_cost[0] * (2 ** ($i-1)));
            $crystal_cost = 0;
            $production = round(5000 * 5 * (2 ** ($i-1)));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 5,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'storage',
                'construction_time' => $construction_time
            ]);
        }

        //Crystal storage
        for ($i=1; $i <= 50; $i++) { 
            $energy_cost = 0;
            $base_cost = [0, 1000];
            $metal_cost = 0;
            $crystal_cost = round($base_cost[1] * (2 ** ($i-1)));
            $production = round(5000 * 5 * (2 ** ($i-1)));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 6,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'storage',
                'construction_time' => $construction_time
            ]);
        }

        //Deuterium storage
        for ($i=1; $i <= 15; $i++) { 
            $energy_cost = 0;
            $base_cost = [1000, 1000];
            $metal_cost = round($base_cost[0] * (2 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (2 ** ($i-1)));
            $production = round(5000 * 5 * (2 ** ($i-1)));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 7,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => 0,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => 'storage',
                'construction_time' => $construction_time
            ]);
        }

        //Robotics factory
        for ($i=1; $i <= 50; $i++) { 
            $energy_cost = 0;
            $base_cost = [400, 120, 200];
            $metal_cost = round($base_cost[0] * (2 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (2 ** ($i-1)));
            $deuterium_cost = round($base_cost[2] * (2 ** ($i-1)));
            $production = 1 / ($i + 1);
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 8,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => $deuterium_cost,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => NULL,
                'construction_time' => $construction_time
            ]);
        }

        //Shipyard
        for ($i=1; $i <= 17; $i++) { 
            $energy_cost = 0;
            $base_cost = [400, 200, 100];
            $metal_cost = round($base_cost[0] * (2 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (2 ** ($i-1)));
            $deuterium_cost = round($base_cost[2] * (2 ** ($i-1)));
            $production = ($metal_cost + $crystal_cost) / (2500 * (1 + $i-1) * (2 ** 1));
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 9,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => $deuterium_cost,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => NULL,
                'construction_time' => $construction_time
            ]);
        }

        //Research lab
        for ($i=1; $i <= 12; $i++) { 
            $energy_cost = 0;
            $base_cost = [200, 400, 200];
            $metal_cost = round($base_cost[0] * (2 ** ($i-1)));
            $crystal_cost = round($base_cost[1] * (2 ** ($i-1)));
            $deuterium_cost = round($base_cost[2] * (2 ** ($i-1)));
            $production = 0;
            $construction_time = round(($metal_cost + $crystal_cost) / (log($i + 1) * $universe_acceleration_factor));
            DB::table('building_levels')->insert([
                'building_id' => 10,
                'level' => $i-1,
                'metal_cost' => $metal_cost,
                'crystal_cost' => $crystal_cost,
                'deuterium_cost' => $deuterium_cost,
                'energy_cost' => $energy_cost,
                'production_rate' => $production,
                'resource_type' => NULL,
                'construction_time' => $construction_time
            ]);
        }
    }
}