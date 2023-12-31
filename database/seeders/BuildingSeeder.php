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
                    'en' => 'Metal Mine',
                    'es' => 'Mina de metal'
                ],
                'description' => [
                    'en' => 'Produces metal from the planet\'s crust.',
                    'es' => 'Produce metal a partir de la corteza del planeta.'
                ],
                'image' => '/images/buildings/metal_mine.jpg'
            ],
            [
                'name' => [
                    'en' => 'Crystal Mine',
                    'es' => 'Mina de cristal'
                ],
                'description' => [
                    'en' => 'Produces crystal from crystal deposits.',
                    'es' => 'Produce cristal a partir de los depósitos de cristal.'
                ],
                'image' => '/images/buildings/crystal_mine.jpg'
            ],
            [
                'name' => [
                    'en' => 'Deuterium Synthesizer',
                    'es' => 'Sintetizador de deuterio'
                ],
                'description' => [
                    'en' => 'Produces deuterium by fusing hydrogen from the planet\'s atmosphere.',
                    'es' => 'Produce deuterio fusionando hidrógeno de la atmósfera del planeta.'
                ],
                'image' => '/images/buildings/deuterium_mine.jpg'
            ],
            [
                'name' => [
                    'en' => 'Solar Panel',
                    'es' => 'Panel solar'
                ],
                'description' => [
                    'en' => 'Generates energy by converting solar radiation.',
                    'es' => 'Genera energía convirtiendo la radiación solar.'
                ],
                'image' => '/images/buildings/solar_panel.jpg'
            ],
            [
                'name' => [
                    'en' => 'Metal Storage',
                    'es' => 'Almacén de metal'
                ],
                'description' => [
                    'en' => 'Stores metal.',
                    'es' => 'Almacena metal.'
                ],
                'image' => '/images/buildings/Metal_Storage.webp'
            ],
            [
                'name' => [
                    'en' => 'Crystal Storage',
                    'es' => 'Almacén de cristal'
                ],
                'description' => [
                    'en' => 'Stores crystal.',
                    'es' => 'Almacena cristal.'
                ],
                'image' => '/images/buildings/Crystal_Storage.webp'
            ],
            [
                'name' => [
                    'en' => 'Deuterium Storage',
                    'es' => 'Almacén de deuterio'
                ],
                'description' => [
                    'en' => 'Stores deuterium.',
                    'es' => 'Almacena deuterio.'
                ],
                'image' => '/images/buildings/Deuterium_Tank.webp'
            ],
            [
                'name' => [
                    'en' => 'Robotics Factory',
                    'es' => 'Fábrica de robots'
                ],
                'description' => [
                    'en' => 'Produces and maintains robotic units.',
                    'es' => 'Produce y mantiene unidades robóticas.'
                ],
                'image' => '/images/buildings/Robotics_Factory.webp'
            ],
            [
                'name' => [
                    'en' => 'Shipyard',
                    'es' => 'Hangar'
                ],
                'description' => [
                    'en' => 'Stores and maintains fleet units.',
                    'es' => 'Almacena y mantiene unidades de la flota.'
                ],
                'image' => '/images/buildings/Shipyard.webp'
            ],
            [
                'name' => [
                    'en' => 'Research Lab',
                    'es' => 'Laboratorio de investigación'
                ],
                'description' => [
                    'en' => 'Allows for advanced technological research.',
                    'es' => 'Permite la investigación tecnológica avanzada.'
                ],
                'image' => '/images/buildings/Research_Lab.webp'
            ]
        ];

        foreach ($buildings as $building) {
            $newBuilding = new Building();
            $newBuilding->setTranslations('name', $building['name']);
            $newBuilding->setTranslations('description', $building['description']);
            $newBuilding->image = $building['image'];
            $newBuilding->save();
        }
    }
}