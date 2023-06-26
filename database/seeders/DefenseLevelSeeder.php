<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefenseLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //defense_id, mc, cc, dc,
        $data = [
            [
                [1,2000,0,0],
                [2,1500,500,0],
                [3,6000,2000,0],
                [4,20000,15000,2000],
                [5,5000,3000,0],
                [6,50000,50000,30000],
                [7,10000,10000,0],
                [8,50000,50000,1000000],
                [9,60000,60000,3000],
                [10,12500,2500,10000],
            ],
        ];
        foreach ($data as $shipLevels) {
            foreach ($shipLevels as $shipLevel) {
                DB::table('defense_levels')->insert([
                    'defense_id' => $shipLevel[0],
                    'metal_cost' => $shipLevel[1],
                    'crystal_cost' => $shipLevel[2],
                    'deuterium_cost' => $shipLevel[3],
                ]);
            }
        }
    }
}