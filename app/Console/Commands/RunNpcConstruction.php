<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NpcConstructionService;
use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;

class RunNpcConstruction extends Command
{
    protected $signature = 'npc:construct';
    protected $description = 'IA construye estructuras en planetas NPC';

    protected $npcService;

    public function __construct(NpcConstructionService $npcService)
    {
        parent::__construct();
        $this->npcService = $npcService;
    }

    public function handle()
    {
        $numBots = env('NUM_BOTS');

        // Obtener todos los planetas de los NPCs
        $planets = Planet::where('user_id', '<=', $numBots)->get();
        
        foreach ($planets as $planet) {
            // Obtener edificios tipo "resources" del planeta
            $buildingPlanets = BuildingPlanet::where('planet_id', $planet->id)
                ->where('type', 'resources')
                ->get();

            // Obtener niveles de los edificios
            $buildingLevels = BuildingLevel::all();

            // Construir usando el servicio de NPC
            $this->npcService->build($planet);
        }
    }
}
