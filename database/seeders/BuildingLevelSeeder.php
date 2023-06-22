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
                [1, 0, 0, 0, 0, 0, 0, 'metal'],
                [1, 1, 60, 15, 0, 11, 30, 'metal'],
                [1, 2, 90, 22, 0, 25, 33, 'metal'],
                [1, 3, 135, 33, 0, 40, 72, 'metal'],
                [1, 4, 202, 50, 0, 59, 119, 'metal'],
                [1, 5, 303, 75, 0, 81, 175, 'metal'],
                [1, 6, 455, 113, 0, 107, 241, 'metal'],
                [1, 7, 683, 170, 0, 137, 318, 'metal'],
                [1, 8, 1025, 256, 0, 172, 409, 'metal'],
                [1, 9, 1537, 384, 0, 213, 514, 'metal'],
                [1, 10, 2306, 576, 0, 260, 636, 'metal'],
            ],
            // Valores para building_id = 2
            [
                [2, 0, 0, 0, 0, 0, 0, 'crystal'],
                [2, 1, 48, 24, 0, 11, 22, 'crystal'],
                [2, 2, 76, 38, 0, 25, 48, 'crystal'],
                [2, 3, 122, 61, 0, 40, 79, 'crystal'],
                [2, 4, 196, 98, 0, 59, 117, 'crystal'],
                [2, 5, 314, 157, 0, 81, 161, 'crystal'],
                [2, 6, 503, 251, 0, 107, 212, 'crystal'],
                [2, 7, 805, 402, 0, 137, 272, 'crystal'],
                [2, 8, 1288, 644, 0, 172, 342, 'crystal'],
                [2, 9, 2061, 1030, 0, 213, 424, 'crystal'],
                [2, 10, 3298, 1649, 0, 260, 518, 'crystal'],
            ],
        
            // Valores para building_id = 3
            [
                [3, 0, 0, 0, 0, 0, 0, 'deuterium'],
                [3, 1, 225, 75, 0, 11, 30, 'deuterium'],
                [3, 2, 337, 112, 0, 25, 43, 'deuterium'],
                [3, 3, 505, 168, 0, 40, 59, 'deuterium'],
                [3, 4, 758, 253, 0, 59, 79, 'deuterium'],
                [3, 5, 1138, 379, 0, 81, 104, 'deuterium'],
                [3, 6, 1706, 569, 0, 107, 136, 'deuterium'],
                [3, 7, 2560, 853, 0, 137, 176, 'deuterium'],
                [3, 8, 3840, 1280, 0, 172, 226, 'deuterium'],
                [3, 9, 5760, 1920, 0, 213, 290, 'deuterium'],
                [3, 10, 8640, 2880, 0, 260, 372, 'deuterium'],
            ],
        
            // Valores para building_id = 4
            [
                [7, 0, 0, 0, 0, 0, 0, 'energy'],
                [7, 1, 75, 30, 0, 0, 22, 'energy'],
                [7, 2, 112, 45, 0, 0, 48, 'energy'],
                [7, 3, 168, 67, 0, 0, 79, 'energy'],
                [7, 4, 253, 101, 0, 0, 117, 'energy'],
                [7, 5, 379, 151, 0, 0, 161, 'energy'],
                [7, 6, 569, 227, 0, 0, 212, 'energy'],
                [7, 7, 854, 341, 0, 0, 272, 'energy'],
                [7, 8, 1281, 512, 0, 0, 342, 'energy'],
                [7, 9, 1922, 768, 0, 0, 424, 'energy'],
                [7, 10, 2883, 1153, 0, 0, 518, 'energy'],
            ],
        
            // Valores para building_id = 5
            [
                [5, 0, 0, 0, 0, 0, 0, 'storage'],
                [5, 1, 0, 1000, 0, 0, 0, 'storage'],
                [5, 2, 0, 2000, 0, 0, 0, 'storage'],
                [5, 3, 0, 4000, 0, 0, 0, 'storage'],
                [5, 4, 0, 8000, 0, 0, 0, 'storage'],
                [5, 5, 0, 16000, 0, 0, 0, 'storage'],
                [5, 6, 0, 32000, 0, 0, 0, 'storage'],
                [5, 7, 0, 64000, 0, 0, 0, 'storage'],
                [5, 8, 0, 128000, 0, 0, 0, 'storage'],
                [5, 9, 0, 256000, 0, 0, 0, 'storage'],
                [5, 10, 0, 512000, 0, 0, 0, 'storage'],
            ],
        
            // Valores para building_id = 6
            [
                [6, 0, 0, 0, 0, 0, 0, 'storage'],
                [6, 1, 1000, 1000, 0, 0, 0, 'storage'],
                [6, 2, 2000, 2000, 0, 0, 0, 'storage'],
                [6, 3, 4000, 4000, 0, 0, 0, 'storage'],
                [6, 4, 8000, 8000, 0, 0, 0, 'storage'],
                [6, 5, 16000, 16000, 0, 0, 0, 'storage'],
                [6, 6, 32000, 32000, 0, 0, 0, 'storage'],
                [6, 7, 64000, 64000, 0, 0, 0, 'storage'],
                [6, 8, 128000, 128000, 0, 0, 0, 'storage'],
                [6, 9, 256000, 256000, 0, 0, 0, 'storage'],
                [6, 10, 512000, 512000, 0, 0, 0, 'storage'],
            ],
        
            // Valores para building_id = 7
            [
                [4, 0, 0, 0, 0, 0, 0, 'storage'],
                [4, 1, 1000, 0, 0, 0, 0, 'storage'],
                [4, 2, 2000, 0, 0, 0, 0, 'storage'],
                [4, 3, 4000, 0, 0, 0, 0, 'storage'],
                [4, 4, 8000, 0, 0, 0, 0, 'storage'],
                [4, 5, 16000, 0, 0, 0, 0, 'storage'],
                [4, 6, 32000, 0, 0, 0, 0, 'storage'],
                [4, 7, 64000, 0, 0, 0, 0, 'storage'],
                [4, 8, 128000, 0, 0, 0, 0, 'storage'],
                [4, 9, 256000, 0, 0, 0, 0, 'storage'],
                [4, 10, 512000, 0, 0, 0, 0, 'storage'],
            ],
        
            // Valores para building_id = 8
            [
                [8, 0, 0, 0, 0, 0, 0, NULL],
                [8, 1, 400, 120, 200, 0, 0, NULL],
                [8, 2, 800, 240, 400, 0, 0, NULL],
                [8, 3, 1600, 480, 800, 0, 0, NULL],
                [8, 4, 3200, 960, 1600, 0, 0, NULL],
                [8, 5, 6400, 1920, 3200, 0, 0, NULL],
                [8, 6, 12800, 3840, 6400, 0, 0, NULL],
                [8, 7, 25600, 7680, 12800, 0, 0, NULL],
                [8, 8, 51200, 15360, 25600, 0, 0, NULL],
                [8, 9, 102400, 30720, 51200, 0, 0, NULL],
                [8, 10, 204800, 61440, 102400, 0, 0, NULL],
            ],
        
            // Valores para building_id = 9
            [
                [9, 0, 0, 0, 0, 0, 0, NULL],
                [9, 1, 400, 200, 100, 0, 0, NULL],
                [9, 2, 800, 400, 200, 0, 0, NULL],
                [9, 3, 1600, 800, 400, 0, 0, NULL],
                [9, 4, 3200, 1600, 800, 0, 0, NULL],
                [9, 5, 6400, 3200, 1600, 0, 0, NULL],
                [9, 6, 12800, 6400, 3200, 0, 0, NULL],
                [9, 7, 25600, 12800, 6400, 0, 0, NULL],
                [9, 8, 51200, 25600, 12800, 0, 0, NULL],
                [9, 9, 102400, 51200, 25600, 0, 0, NULL],
                [9, 10, 204800, 102400, 51200, 0, 0, NULL],
            ],
        
            // Valores para building_id = 10
            [
                [10, 0, 0, 0, 0, 0, 0, NULL],
                [10, 1, 400, 200, 0, 200, 0, NULL],
                [10, 2, 800, 400, 0, 400, 0, NULL],
                [10, 3, 1600, 800, 0, 800, 0, NULL],
                [10, 4, 3200, 1600, 0, 1600, 0, NULL],
                [10, 5, 6400, 3200, 0, 3200, 0, NULL],
                [10, 6, 12800, 6400, 0, 6400, 0, NULL],
                [10, 7, 25600, 12800, 0, 12800, 0, NULL],
                [10, 8, 51200, 25600, 0, 25600, 0, NULL],
                [10, 9, 102400, 51200, 0, 51200, 0, NULL],
                [10, 10, 204800, 102400, 0, 102400, 0, NULL]
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