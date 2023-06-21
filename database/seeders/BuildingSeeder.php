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
                'name' => [
                    'en' => 'METAL MINE',
                    'es' => 'MINA DE METAL'
                ],
                'description' => [
                    'en' => 'Produces metal from the planet\'s crust.',
                    'es' => 'Produce metal a partir de la corteza del planeta.'
                ]
            ],
            [
                'name' => [
                    'en' => 'CRYSTAL MINE',
                    'es' => 'MINA DE CRISTAL'
                ],
                'description' => [
                    'en' => 'Produces crystal from crystal deposits.',
                    'es' => 'Produce cristal a partir de los depósitos de cristal.'
                ]
            ],
            [
                'name' => [
                    'en' => 'DEUTERIUM SYNTHESIZER',
                    'es' => 'SINTETIZADOR DE DEUTERIO'
                ],
                'description' => [
                    'en' => 'Produces deuterium by fusing hydrogen from the planet\'s atmosphere.',
                    'es' => 'Produce deuterio fusionando hidrógeno de la atmósfera del planeta.'
                ]
            ],
            [
                'name' => [
                    'en' => 'METAL STORAGE',
                    'es' => 'ALMACÉN DE METAL'
                ],
                'description' => [
                    'en' => 'Stores metal.',
                    'es' => 'Almacena metal.'
                ]
            ],
            [
                'name' => [
                    'en' => 'CRYSTAL STORAGE',
                    'es' => 'ALMACÉN DE CRISTAL'
                ],
                'description' => [
                    'en' => 'Stores crystal.',
                    'es' => 'Almacena cristal.'
                ]
            ],
            [
                'name' => [
                    'en' => 'DEUTERIUM STORAGE',
                    'es' => 'ALMACÉN DE DEUTERIO'
                ],
                'description' => [
                    'en' => 'Stores deuterium.',
                    'es' => 'Almacena deuterio.'
                ]
            ],
            [
                'name' => [
                    'en' => 'SOLAR PANEL',
                    'es' => 'PANEL SOLAR'
                ],
                'description' => [
                    'en' => 'Generates energy by converting solar radiation.',
                    'es' => 'Genera energía convirtiendo la radiación solar.'
                ]
            ],
            [
                'name' => [
                    'en' => 'ROBOTICS FACTORY',
                    'es' => 'FÁBRICA DE ROBOTS'
                ],
                'description' => [
                    'en' => 'Produces and maintains robotic units.',
                    'es' => 'Produce y mantiene unidades robóticas.'
                ]
            ],
            [
                'name' => [
                    'en' => 'SHIPYARD',
                    'es' => 'ASTILLERO'
                ],
                'description' => [
                    'en' => 'Stores and maintains fleet units.',
                    'es' => 'Almacena y mantiene unidades de la flota.'
                ]
            ],
            [
                'name' => [
                    'en' => 'RESEARCH LAB',
                    'es' => 'LABORATORIO DE INVESTIGACIÓN'
                ],
                'description' => [
                    'en' => 'Allows for advanced technological research.',
                    'es' => 'Permite la investigación tecnológica avanzada.'
                ]
            ]
        ];

        foreach ($buildings as $building) {
            $newBuilding = new Building();
            $newBuilding->setTranslations('name', $building['name']);
            $newBuilding->setTranslations('description', $building['description']);
            $newBuilding->save();
        }
    }
}