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
    
    public function updateResources()
    {
        $userID = auth()->id();
        
        $Usergame = Usergame::where('user_id', $userID)->first();
        $planet = Planet::where('user_id', $userID)->first();
        $buildingPlanets = BuildingPlanet::where('planet_id', $planet->id)->get();
        $buildingLevels = BuildingLevel::all();
        
        $metal_mine = BuildingPlanet::where('building_id', 1)->first();
        $crystal_mine = BuildingPlanet::where('building_id', 2)->first();
        $deuterium_mine = BuildingPlanet::where('building_id', 3)->first();


        $metal_production = BuildingLevel::where('building_id', 1)
        ->where('level', $metal_mine->level)
        ->pluck('production_rate')
        ->first();

        $crystal_production = BuildingLevel::where('building_id', 2)
        ->where('level', $crystal_mine->level)
        ->pluck('production_rate')
        ->first();

        $deuterium_production = BuildingLevel::where('building_id', 3)
        ->where('level', $deuterium_mine->level)
        ->pluck('production_rate')
        ->first();


        if ($Usergame) {
            $Usergame->metal += (($metal_production + 40) / 3600) * 5;
            $Usergame->crystal += (($crystal_production + 15) / 3600) * 5;
            $Usergame->deuterium += $deuterium_production;
            $Usergame->save();
        }
        
        return response()->json($Usergame);
    }
}
