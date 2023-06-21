<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BuildingSeeder;
use Database\Seeders\BuildingLevelSeeder;

use App\Models\User;
use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\Usergame;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BuildingSeeder::class);
        $this->call(BuildingLevelSeeder::class);
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678'
        ]);
        
        $planet = Planet::createDefault($user->id);
        $buildingPlanet = BuildingPlanet::createDefault($planet->id);
        $Usergame = Usergame::createDefault($user->id);
    }
}
