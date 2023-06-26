<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Defense;

class DefenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defenses = [
            [
                'name' => [
                    'en' => 'Rocket Launcher',
                    'es' => 'Lanzamisiles'
                ],
                'description' => [
                    'en' => 'Basic defense structure that fires rockets at attacking units.',
                    'es' => 'Estructura de defensa básica que dispara cohetes contra unidades atacantes.'
                ],
                'image' => '/images/defenses/Rocket Launcher.jpg'
            ],
            [
                'name' => [
                    'en' => 'Light Laser',
                    'es' => 'Láser ligero'
                ],
                'description' => [
                    'en' => 'Fast and accurate laser weapon used for defense against enemy ships.',
                    'es' => 'Arma láser rápida y precisa utilizada para la defensa contra naves enemigas.'
                ],
                'image' => '/images/defenses/Light Laser.jpg'
            ],
            [
                'name' => [
                    'en' => 'Heavy Laser',
                    'es' => 'Láser pesado'
                ],
                'description' => [
                    'en' => 'Powerful laser weapon capable of inflicting significant damage to enemy ships.',
                    'es' => 'Poderosa arma láser capaz de infligir un daño significativo a las naves enemigas.'
                ],
                'image' => '/images/defenses/Heavy Laser.jpg'
            ],
            [
                'name' => [
                    'en' => 'Gauss Cannon',
                    'es' => 'Cañón Gauss'
                ],
                'description' => [
                    'en' => 'Advanced electromagnetic weapon that can destroy enemy ships with great force.',
                    'es' => 'Arma electromagnética avanzada que puede destruir naves enemigas con gran fuerza.'
                ],
                'image' => '/images/defenses/Gauss Cannon.jpg'
            ],
            [
                'name' => [
                    'en' => 'Ion Cannon',
                    'es' => 'Cañón iónico'
                ],
                'description' => [
                    'en' => 'Energy-based weapon that emits powerful ion beams to eliminate enemy targets.',
                    'es' => 'Arma basada en energía que emite potentes haces iónicos para eliminar objetivos enemigos.'
                ],
                'image' => '/images/defenses/Ion Cannon.jpg'
            ],
            [
                'name' => [
                    'en' => 'Plasma Turret',
                    'es' => 'Torreta de plasma'
                ],
                'description' => [
                    'en' => 'Cutting-edge plasma weapon capable of causing massive destruction to enemy fleets.',
                    'es' => 'Arma de plasma de vanguardia capaz de causar una destrucción masiva a las flotas enemigas.'
                ],
                'image' => '/images/defenses/Plasma Turret.jpg'
            ],
            [
                'name' => [
                    'en' => 'Small Shield Dome',
                    'es' => 'Cúpula de protección pequeña'
                ],
                'description' => [
                    'en' => 'Protective dome that provides a small shield to defend against enemy attacks.',
                    'es' => 'Cúpula de protección que proporciona un escudo pequeño para defenderse de los ataques enemigos.'
                ],
                'image' => '/images/defenses/Small Shield Dome.jpg'
            ],
            [
                'name' => [
                    'en' => 'Large Shield Dome',
                    'es' => 'Cúpula de protección grande'
                ],
                'description' => [
                    'en' => 'Powerful shield dome that provides a large shield to protect against enemy assaults.',
                    'es' => 'Cúpula de protección potente que proporciona un escudo grande para protegerse de los asaltos enemigos.'
                ],
                'image' => '/images/defenses/Large Shield Dome.jpg'
            ],
            [
                'name' => [
                    'en' => 'Anti-Ballistic Missiles',
                    'es' => 'Misiles antibalísticos'
                ],
                'description' => [
                    'en' => 'Missiles designed to intercept and destroy enemy ballistic missiles.',
                    'es' => 'Misiles diseñados para interceptar y destruir misiles balísticos enemigos.'
                ],
                'image' => '/images/defenses/Anti-Ballistic Missiles.jpg'
            ],
            [
                'name' => [
                    'en' => 'Interplanetary Missiles',
                    'es' => 'Misiles interplanetarios'
                ],
                'description' => [
                    'en' => 'Powerful missiles capable of launching devastating attacks on enemy planets.',
                    'es' => 'Misiles potentes capaces de lanzar ataques devastadores contra planetas enemigos.'
                ],
                'image' => '/images/defenses/Interplanetary Missiles.jpg'
            ]
        ];

        foreach ($defenses as $defense) {
            $newDefense = new Defense();
            $newDefense->setTranslations('name', $defense['name']);
            $newDefense->setTranslations('description', $defense['description']);
            $newDefense->image = $defense['image'];
            $newDefense->save();
        }
    }
}