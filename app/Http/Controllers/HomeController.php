<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\Usergame;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;

class HomeController extends Controller
{
    public function index()
    {  
        try {
            $userID = auth()->id();
            
            $Usergame = Usergame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $buildingPlanets = BuildingPlanet::where('planet_id', $planet->id)->get();
            $buildingLevels = BuildingLevel::all();
            return view('home.index', [
                'planet' => $planet,
                'Usergame' => $Usergame,
                'buildingPlanets' => $buildingPlanets,
                'buildingLevels' => $buildingLevels,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }
}
