<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\ShipPlanet;
use App\Models\DefensePlanet;
use App\Models\Usergame;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
        $user = \App\Models\User::factory()->create([
            'name' => 'Jugador',
            'email' => 'test@example.com',
            'password' => '12345678'
        ]);   
        $planet = Planet::createDefault($user->id);
        $buildingPlanet = BuildingPlanet::createDefault($planet->id);
        $userGame = UserGame::createDefault($user->id);
        $shipPlanet = ShipPlanet::createDefault($planet->id);
        $defensePlanet = DefensePlanet::createDefault($planet->id);
        for ($i = 1; $i <= 75; $i++) {
                $user = \App\Models\User::factory()->create([
                    'name' => 'CPU '.$i
                ]);   
            $planet = Planet::createDefault($user->id);
            $buildingPlanet = BuildingPlanet::createDefault($planet->id);
            $userGame = UserGame::createDefault($user->id);
            $shipPlanet = ShipPlanet::createDefault($planet->id);
            $defensePlanet = DefensePlanet::createDefault($planet->id);
        }
    } catch (\Exception $e) {
        LOG::INFO($e->getMessage());
    }
    }
}
