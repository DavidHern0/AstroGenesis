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
        //ship_id, mc, cc, dc,
        $data = [
            [
                [1,3000,1000,0],
                [2,6000,4000,0],
                [3,20000,7000,2000],
                [4,45000,15000,0],
                [5,30000,40000,15000],
                [6,50000,25000,15000],
                [7,60000,50000,15000],
                [8,5000000,4000000,1000000],
                [9,2000,2000,0],
                [10,6000,6000,0],
                [11,10000,20000,10000],
                [12,10000,6000,2000],
                [13,0,1000,0],
                [14,0,2000,500],
            ],
        ];
        foreach ($data as $shipLevels) {
            foreach ($shipLevels as $shipLevel) {
                DB::table('ship_levels')->insert([
                    'ship_id' => $shipLevel[0],
                    'metal_cost' => $shipLevel[1],
                    'crystal_cost' => $shipLevel[2],
                    'deuterium_cost' => $shipLevel[3],
                ]);
            }
        }
    }
}