<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ResourcesPlayersService;
use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;

class RunResourcesPlayers extends Command
{
    protected $signature = 'resources:players';
    protected $description = 'Genera recursos a los jugadores cada minuto';

    protected $ResourcesService;

    public function __construct(ResourcesPlayersService $ResourcesService)
    {
        parent::__construct();
        $this->ResourcesService = $ResourcesService;
    }

    public function handle()
    {
            $this->ResourcesService->updateAll();
        }
    }