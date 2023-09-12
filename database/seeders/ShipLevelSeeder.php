<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //ship_id, mc, cc, dc, ct, cc
        $data = [
            [
                [1,3000,1000,0,960,50], // /images/ships/Light Fighter.jpg
                [2,6000,4000,0,2400,100], // /images/ships/Heavy Fighter.jpg
                [3,20000,7000,2000,6480,800], // /images/ships/Cruiser.jpg
                [4,45000,15000,0,14400,1500], // /images/ships/Battleship.jpg
                [5,30000,40000,15000,16800,750], // /images/ships/Battlecruiser.jpg
                [6,50000,25000,15000,18000,500], // /images/ships/Bomber.jpg
                [7,60000,50000,15000,26400,2000], // /images/ships/Destroyer.jpg
                [8,5000000,4000000,1000000,2160000,1000000], // /images/ships/Deathstar.jpg
                [9,2000,2000,0,960,5000], // /images/ships/Small Cargo.jpg
                [10,6000,6000,0,2880,25000], // /images/ships/Large Cargo.jpg
                [11,10000,20000,10000,7200,7500], // /images/ships/Colony Ship.jpg
                [12,10000,6000,2000,3840,20000], // /images/ships/Recycler.jpg
                [13,0,1000,0,240,5], // /images/ships/Espionage Probe.jpg
                [14,0,2000,500,480,0], // /images/ships/Solar Satellite.jpg
            ],
        ];
        foreach ($data as $shipLevels) {
            foreach ($shipLevels as $shipLevel) {
                DB::table('ship_levels')->insert([
                    'ship_id' => $shipLevel[0],
                    'metal_cost' => $shipLevel[1],
                    'crystal_cost' => $shipLevel[2],
                    'deuterium_cost' => $shipLevel[3],
                    'construction_time' => $shipLevel[4],
                    'cargo_capacity' => $shipLevel[5]
                ]);
            }
        }
    }
}