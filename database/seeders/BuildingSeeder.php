<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buildings = [
            [
                'en' => [
                    'name' => 'METAL MINE',
                    'description' => 'Produces metal from the planet\'s crust.'
                ],
                'es' => [
                    'name' => 'MINA DE METAL',
                    'description' => 'Produce metal a partir de la corteza del planeta.'
                ]
            ],
            [
                'en' => [
                    'name' => 'CRYSTAL MINE',
                    'description' => 'Produces crystal from crystal deposits.'
                ],
                'es' => [
                    'name' => 'MINA DE CRISTAL',
                    'description' => 'Produce cristal a partir de los depósitos de cristal.'
                ]
            ],
            [
                'en' => [
                    'name' => 'DEUTERIUM SYNTHESIZER',
                    'description' => 'Produces deuterium by fusing hydrogen from the planet\'s atmosphere.'
                ],
                'es' => [
                    'name' => 'SINTETIZADOR DE DEUTERIO',
                    'description' => 'Produce deuterio fusionando hidrógeno de la atmósfera del planeta.'
                ]
            ],
            [
                'en' => [
                    'name' => 'METAL STORAGE',
                    'description' => 'Stores metal.'
                ],
                'es' => [
                    'name' => 'ALMACÉN DE METAL',
                    'description' => 'Almacena metal.'
                ]
            ],
            [
                'en' => [
                    'name' => 'CRYSTAL STORAGE',
                    'description' => 'Stores crystal.'
                ],
                'es' => [
                    'name' => 'ALMACÉN DE CRISTAL',
                    'description' => 'Almacena cristal.'
                ]
            ],
            [
                'en' => [
                    'name' => 'DEUTERIUM STORAGE',
                    'description' => 'Stores deuterium.'
                ],
                'es' => [
                    'name' => 'ALMACÉN DE DEUTERIO',
                    'description' => 'Almacena deuterio.'
                ]
            ],
            [
                'en' => [
                    'name' => 'SOLAR PANEL',
                    'description' => 'Generates energy by converting solar radiation.'
                ],
                'es' => [
                    'name' => 'PANEL SOLAR',
                    'description' => 'Genera energía convirtiendo la radiación solar.'
                ]
            ],
            [
                'en' => [
                    'name' => 'ROBOTICS FACTORY',
                    'description' => 'Produces and maintains robotic units.'
                ],
                'es' => [
                    'name' => 'FÁBRICA DE ROBOTS',
                    'description' => 'Produce y mantiene unidades robóticas.'
                ]
            ],
            [
                'en' => [
                    'name' => 'SHIPYARD',
                    'description' => 'Stores and maintains fleet units.'
                ],
                'es' => [
                    'name' => 'ASTILLERO',
                    'description' => 'Almacena y mantiene unidades de la flota.'
                ]
            ],
            [
                'en' => [
                    'name' => 'RESEARCH LAB',
                    'description' => 'Allows for advanced technological research.'
                ],
                'es' => [
                    'name' => 'LABORATORIO DE INVESTIGACIÓN',
                    'description' => 'Permite la investigación tecnológica avanzada.'
                ]
            ]
        ];

        foreach ($buildings as $building) {
            $newBuilding = new Building();
            $newBuilding->setTranslations('name', $building);
            $newBuilding->setTranslations('description', $building);
            $newBuilding->save();
        }
    }
}