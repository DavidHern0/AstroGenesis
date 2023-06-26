<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BuildingSeeder;
use Database\Seeders\BuildingLevelSeeder;
use Database\Seeders\ShipSeeder;
use Database\Seeders\ShipLevelSeeder;
use App\Models\User;
use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\ShipPlanet;
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
        $this->call(ShipSeeder::class);
        $this->call(ShipLevelSeeder::class);
        $this->call(UserSeeder::class);
    }
}
