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
        $data = [
            // Valores para building_id = 1
            [
                //b_id, lvl, mC, cC, dC, eC, pr, t
                [1, 0, 60, 15, 0, 0, 30, 'metal'],
                [1, 1, 90, 22, 0, 11, 33, 'metal'],
                [1, 2, 135, 33, 0, 25, 72, 'metal'],
                [1, 3, 202, 50, 0, 40, 119, 'metal'],
                [1, 4, 303, 75, 0, 59, 175, 'metal'],
                [1, 5, 455, 113, 0, 81, 241, 'metal'],
                [1, 6, 683, 170, 0, 107, 318, 'metal'],
                [1, 7, 1025, 256, 0, 137, 409, 'metal'],
                [1, 8, 1537, 384, 0, 172, 514, 'metal'],
                [1, 9, 2306, 576, 0, 213, 636, 'metal'],
            ],
            // Valores para building_id = 2
            [
                [2, 0, 48, 24, 0, 0, 22, 'crystal'],
                [2, 1, 76, 38, 0, 11, 48, 'crystal'],
                [2, 2, 122, 61, 0, 25, 79, 'crystal'],
                [2, 3, 196, 98, 0, 40, 117, 'crystal'],
                [2, 4, 314, 157, 0, 59, 161, 'crystal'],
                [2, 5, 503, 251, 0, 81, 212, 'crystal'],
                [2, 6, 805, 402, 0, 107, 272, 'crystal'],
                [2, 7, 1288, 644, 0, 137, 342, 'crystal'],
                [2, 8, 2061, 1030, 0, 172, 424, 'crystal'],
                [2, 9, 3298, 1649, 0, 213, 518, 'crystal'],
            ],
        
            // Valores para building_id = 3
            [
                [3, 0, 225, 75, 0, 0, 0, 'deuterium'],
                [3, 1, 337, 112, 0, 11, 43, 'deuterium'],
                [3, 2, 505, 168, 0, 25, 59, 'deuterium'],
                [3, 3, 758, 253, 0, 40, 79, 'deuterium'],
                [3, 4, 1138, 379, 0, 59, 104, 'deuterium'],
                [3, 5, 1706, 569, 0, 81, 136, 'deuterium'],
                [3, 6, 2560, 853, 0, 107, 176, 'deuterium'],
                [3, 7, 3840, 1280, 0, 137, 226, 'deuterium'],
                [3, 8, 5760, 1920, 0, 172, 290, 'deuterium'],
                [3, 9, 8640, 2880, 0, 213, 372, 'deuterium'],
            ],
        
            // Valores para building_id = 4
            [
                [4, 0, 75, 30, 0, 0, 22, 'energy'],
                [4, 1, 112, 45, 0, 0, 48, 'energy'],
                [4, 2, 168, 67, 0, 0, 79, 'energy'],
                [4, 3, 253, 101, 0, 0, 117, 'energy'],
                [4, 4, 379, 151, 0, 0, 161, 'energy'],
                [4, 5, 569, 227, 0, 0, 212, 'energy'],
                [4, 6, 854, 341, 0, 0, 272, 'energy'],
                [4, 7, 1281, 512, 0, 0, 342, 'energy'],
                [4, 8, 1922, 768, 0, 0, 424, 'energy'],
                [4, 9, 2883, 1153, 0, 0, 518, 'energy'],
            ],
        
            // Valores para building_id = 6
            [
                [5, 0, 1000, 0, 0, 0, 10000, 'storage'],
                [5, 1, 2000, 0, 0, 0, 20000, 'storage'],
                [5, 2, 4000, 0, 0, 0, 35000, 'storage'],
                [5, 3, 8000, 0, 0, 0, 65000, 'storage'],
                [5, 4, 16000, 0, 0, 0, 115000, 'storage'],
                [5, 5, 32000, 0, 0, 0, 215000, 'storage'],
                [5, 6, 64000, 0, 0, 0, 395000, 'storage'],
                [5, 7, 128000, 0, 0, 0, 725000, 'storage'],
                [5, 8, 256000, 0, 0, 0, 1330000, 'storage'],
                [5, 9, 512000, 0, 0, 0, 2435000, 'storage'],
            ],

            // Valores para building_id = 5
            [
                [6, 0, 0, 1000, 0, 0, 10000, 'storage'],
                [6, 1, 0, 2000, 0, 0, 20000, 'storage'],
                [6, 2, 0, 4000, 0, 0, 35000, 'storage'],
                [6, 3, 0, 8000, 0, 0, 65000, 'storage'],
                [6, 4, 0, 16000, 0, 0, 115000, 'storage'],
                [6, 5, 0, 32000, 0, 0, 215000, 'storage'],
                [6, 6, 0, 64000, 0, 0, 395000, 'storage'],
                [6, 7, 0, 128000, 0, 0, 725000, 'storage'],
                [6, 8, 0, 256000, 0, 0, 1330000, 'storage'],
                [6, 9, 0, 512000, 0, 0, 2435000, 'storage'],
            ],

            // Valores para building_id = 7
            [
                [7, 0, 1000, 1000, 0, 0, 10000, 'storage'],
                [7, 1, 2000, 2000, 0, 0, 20000, 'storage'],
                [7, 2, 4000, 4000, 0, 0, 35000, 'storage'],
                [7, 3, 8000, 8000, 0, 0, 65000, 'storage'],
                [7, 4, 16000, 16000, 0, 0, 115000, 'storage'],
                [7, 5, 32000, 32000, 0, 0, 215000, 'storage'],
                [7, 6, 64000, 64000, 0, 0, 395000, 'storage'],
                [7, 7, 128000, 128000, 0, 0, 725000, 'storage'],
                [7, 8, 256000, 256000, 0, 0, 1330000, 'storage'],
                [7, 9, 512000, 512000, 0, 0, 2435000, 'storage'],
            ],
        
            // Valores para building_id = 8
            [
                [8, 0, 400, 120, 200, 0, 0, NULL],
                [8, 1, 800, 240, 400, 0, 0, NULL],
                [8, 2, 1600, 480, 800, 0, 0, NULL],
                [8, 3, 3200, 960, 1600, 0, 0, NULL],
                [8, 4, 6400, 1920, 3200, 0, 0, NULL],
                [8, 5, 12800, 3840, 6400, 0, 0, NULL],
                [8, 6, 25600, 7680, 12800, 0, 0, NULL],
                [8, 7, 51200, 15360, 25600, 0, 0, NULL],
                [8, 8, 102400, 30720, 51200, 0, 0, NULL],
                [8, 9, 204800, 61440, 102400, 0, 0, NULL],
            ],
        
            // Valores para building_id = 9
            [
                [9, 0, 400, 200, 100, 0, 0, NULL],
                [9, 1, 800, 400, 200, 0, 0, NULL],
                [9, 2, 1600, 800, 400, 0, 0, NULL],
                [9, 3, 3200, 1600, 800, 0, 0, NULL],
                [9, 4, 6400, 3200, 1600, 0, 0, NULL],
                [9, 5, 12800, 6400, 3200, 0, 0, NULL],
                [9, 6, 25600, 12800, 6400, 0, 0, NULL],
                [9, 7, 51200, 25600, 12800, 0, 0, NULL],
                [9, 8, 102400, 51200, 25600, 0, 0, NULL],
                [9, 9, 204800, 102400, 51200, 0, 0, NULL],
            ],
        
            // Valores para building_id = 10
            [
                [10, 0, 400, 200, 0, 200, 0, NULL],
                [10, 1, 800, 400, 0, 400, 0, NULL],
                [10, 2, 1600, 800, 0, 800, 0, NULL],
                [10, 3, 3200, 1600, 0, 1600, 0, NULL],
                [10, 4, 6400, 3200, 0, 3200, 0, NULL],
                [10, 5, 12800, 6400, 0, 6400, 0, NULL],
                [10, 6, 25600, 12800, 0, 12800, 0, NULL],
                [10, 7, 51200, 25600, 0, 25600, 0, NULL],
                [10, 8, 102400, 51200, 0, 51200, 0, NULL],
                [10, 9, 204800, 102400, 0, 102400, 0, NULL]
            ],
        ];
        foreach ($data as $buildingLevels) {
            foreach ($buildingLevels as $buildingLevel) {
                DB::table('building_levels')->insert([
                    'building_id' => $buildingLevel[0],
                    'level' => $buildingLevel[1],
                    'metal_cost' => $buildingLevel[2],
                    'crystal_cost' => $buildingLevel[3],
                    'deuterium_cost' => $buildingLevel[4],
                    'energy_cost' => $buildingLevel[5],
                    'production_rate' => $buildingLevel[6],
                    'resource_type' => $buildingLevel[7],
                ]);
            }
        }
    }
}