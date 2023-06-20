<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\BuildingPlanet;
use App\Models\Usergame;

class HomeController extends Controller
{
    public function index()
    {  
        try {
            $userID = auth()->id();
            
            $Usergame = Usergame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $BuildingPlanets = BuildingPlanet::where('planet_id', $planet->id)->get();
            return view('home.index', [
                'planet' => $planet,
                'Usergame' => $Usergame,
                'BuildingPlanets' => $BuildingPlanets
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }
}
