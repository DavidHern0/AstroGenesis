<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ship;

class ShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ships = [
            [
                'name' => [
                    'en' => 'Light Fighter',
                    'es' => 'Caza ligero'
                ],
                'description' => [
                    'en' => 'The Light Fighter is a fast and agile ship that excels in combat against other light vessels. It is relatively cheap and can be produced quickly.',
                    'es' => 'El Caza ligero es una nave rápida y ágil que se destaca en combates contra otras naves ligeras. Es relativamente barato y se puede producir rápidamente.'
                ],
                'image' => '/images/ships/Light Fighter.jpg'
            ],
            [
                'name' => [
                    'en' => 'Heavy Fighter',
                    'es' => 'Caza pesado'
                ],
                'description' => [
                    'en' => 'The Heavy Fighter is a versatile ship that is effective against both light and heavy vessels. It has a good balance of speed, firepower, and durability.',
                    'es' => 'El Caza pesado es una nave versátil que es efectiva contra naves ligeras y pesadas. Tiene un buen equilibrio entre velocidad, potencia de fuego y resistencia.'
                ],
                'image' => '/images/ships/Heavy Fighter.jpg'
            ],
            [
                'name' => [
                    'en' => 'Cruiser',
                    'es' => 'Crucero'
                ],
                'description' => [
                    'en' => 'The Cruiser is a well-rounded ship that can engage in various combat scenarios. It has decent firepower and is capable of carrying a moderate amount of cargo.',
                    'es' => 'El Crucero es una nave equilibrada que puede participar en varios escenarios de combate. Tiene una potencia de fuego decente y es capaz de transportar una cantidad moderada de carga.'
                ],
                'image' => '/images/ships/Cruiser.jpg'
            ],
            [
                'name' => [
                    'en' => 'Battleship',
                    'es' => 'Acorazado'
                ],
                'description' => [
                    'en' => 'The Battleship is a powerful ship designed for heavy combat. It has impressive firepower and is capable of dealing significant damage to enemy fleets.',
                    'es' => 'El Acorazado es una nave poderosa diseñada para combates pesados. Tiene una potencia de fuego impresionante y es capaz de infligir un daño significativo a las flotas enemigas.'
                ],
                'image' => '/images/ships/Battleship.jpg'
            ],
            [
                'name' => [
                    'en' => 'Battlecruiser',
                    'es' => 'Acorazado de batalla'
                ],
                'description' => [
                    'en' => 'The Battlecruiser is a versatile ship that combines the firepower of a Battleship with the speed of a Cruiser. It excels in both offensive and defensive operations.',
                    'es' => 'El Acorazado de batalla es una nave versátil que combina la potencia de fuego de un Acorazado con la velocidad de un Crucero. Sobresale tanto en operaciones ofensivas como defensivas.'
                ],
                'image' => '/images/ships/Battlecruiser.jpg'
            ],
            [
                'name' => [
                    'en' => 'Bomber',
                    'es' => 'Bombardero'
                ],
                'description' => [
                    'en' => 'The Bomber is a specialized ship designed for planetary bombardment. It has a devastating payload and is capable of inflicting heavy damage to enemy defenses.',
                    'es' => 'El Bombardero es una nave especializada diseñada para el bombardeo planetario. Tiene una carga explosiva devastadora y es capaz de infligir un gran daño a las defensas enemigas.'
                ],
                'image' => '/images/ships/Bomber.jpg'
            ],
            [
                'name' => [
                    'en' => 'Destroyer',
                    'es' => 'Destructor'
                ],
                'description' => [
                    'en' => 'The Destroyer is a heavily armed ship designed for taking out enemy defenses. It has excellent firepower and is particularly effective against defensive structures.',
                    'es' => 'El Destructor es una nave fuertemente armada diseñada para eliminar defensas enemigas. Tiene una potencia de fuego excelente y es particularmente efectivo contra estructuras defensivas.'
                ],
                'image' => '/images/ships/Destroyer.jpg'
            ],
            [
                'name' => [
                    'en' => 'Deathstar',
                    'es' => 'Estrella de la muerte'
                ],
                'description' => [
                    'en' => 'The Deathstar is the ultimate superweapon in the game. It has unmatched firepower and can annihilate entire fleets and planets with a single strike.',
                    'es' => 'La Estrella de la muerte es la superarma definitiva en el juego. Tiene una potencia de fuego inigualable y puede aniquilar flotas y planetas enteros con un solo golpe.'
                ],
                'image' => '/images/ships/Deathstar.jpg'
            ],
            [
                'name' => [
                    'en' => 'Small Cargo',
                    'es' => 'Carga pequeña'
                ],
                'description' => [
                    'en' => 'The Small Cargo is a basic transport ship used for moving resources between planets. It has a limited cargo capacity but is relatively fast and inexpensive.',
                    'es' => 'La Carga pequeña es una nave de transporte básica utilizada para mover recursos entre planetas. Tiene una capacidad de carga limitada, pero es relativamente rápida y económica.'
                ],
                'image' => '/images/ships/Small Cargo.jpg'
            ],
            [
                'name' => [
                    'en' => 'Large Cargo',
                    'es' => 'Carga grande'
                ],
                'description' => [
                    'en' => 'The Large Cargo is an upgraded version of the Small Cargo with a much larger cargo capacity. It is slower and more expensive but can transport substantial amounts of resources.',
                    'es' => 'La Carga grande es una versión mejorada de la Carga pequeña con una capacidad de carga mucho mayor. Es más lenta y más cara, pero puede transportar cantidades sustanciales de recursos.'
                ],
                'image' => '/images/ships/Large Cargo.jpg'
            ],
            [
                'name' => [
                    'en' => 'Colony Ship',
                    'es' => 'Nave colonizadora'
                ],
                'description' => [
                    'en' => 'The Colony Ship is used for establishing new colonies on unoccupied planets. It carries the necessary equipment and supplies to create a functioning colony.',
                    'es' => 'La Nave colonizadora se utiliza para establecer nuevas colonias en planetas desocupados. Transporta el equipo y los suministros necesarios para crear una colonia funcional.'
                ],
                'image' => '/images/ships/Colony Ship.jpg'
            ],
            [
                'name' => [
                    'en' => 'Recycler',
                    'es' => 'Reciclador'
                ],
                'description' => [
                    'en' => 'The Recycler is a specialized ship used for collecting debris after battles. It can salvage resources from destroyed ships and structures, providing a valuable source of income.',
                    'es' => 'El Reciclador es una nave especializada utilizada para recoger escombros después de las batallas. Puede recuperar recursos de naves y estructuras destruidas, proporcionando una valiosa fuente de ingresos.'
                ],
                'image' => '/images/ships/Recycler.jpg'
            ],
            [
                'name' => [
                    'en' => 'Espionage Probe',
                    'es' => 'Sonda de espionaje'
                ],
                'description' => [
                    'en' => 'The Espionage Probe is a stealthy reconnaissance ship used for gathering intelligence on enemy planets. It is equipped with advanced sensors and cloaking technology.',
                    'es' => 'La Sonda de espionaje es una nave de reconocimiento sigilosa utilizada para recopilar información de inteligencia sobre planetas enemigos. Está equipada con sensores avanzados y tecnología de camuflaje.'
                ],
                'image' => '/images/ships/Espionage Probe.jpg'
            ],
            [
                'name' => [
                    'en' => 'Solar Satellite',
                    'es' => 'Satélite solar'
                ],
                'description' => [
                    'en' => 'The Solar Satellite is a stationary structure that generates energy from the sun. It provides a steady income of energy without requiring any maintenance or resources.',
                    'es' => 'El Satélite solar es una estructura estacionaria que genera energía a partir del sol. Proporciona un ingreso constante de energía sin requerir ningún mantenimiento ni recursos.'
                ],
                'image' => '/images/ships/Solar Satellite.jpg'
            ]
        ];

        foreach ($ships as $ship) {
            $newShip = new ship();
            $newShip->setTranslations('name', $ship['name']);
            $newShip->setTranslations('description', $ship['description']);
            $newShip->image = $ship['image'];
            $newShip->save();
        }
    }
}