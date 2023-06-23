<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\Usergame;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use Illuminate\Support\Facades\Log;

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
            if ($metal_production) {
                $metal_production_per_hour = ($metal_production + 40) / 3600;
                if ($Usergame->metal < $Usergame->metal_storage) {
                    $available_metal_space = $Usergame->metal_storage - $Usergame->metal;
                    $Usergame->metal += min($available_metal_space, $metal_production_per_hour * 5);
                }
            }
            if ($crystal_production) {
                $crystal_production_per_hour = ($crystal_production + 15) / 3600;
                if ($Usergame->crystal < $Usergame->crystal_storage) {
                    $available_crystal_space = $Usergame->crystal_storage - $Usergame->crystal;
                    $Usergame->crystal += min($available_crystal_space, $crystal_production_per_hour * 5);
                }
            }
            if ($deuterium_production) {
                $deuterium_production_per_hour = ($deuterium_production + 15) / 3600;
                if ($Usergame->deuterium < $Usergame->deuterium_storage) {
                    $available_deuterium_space = $Usergame->deuterium_storage - $Usergame->deuterium;
                    $Usergame->deuterium += min($available_deuterium_space, $deuterium_production_per_hour * 5);
                }
            }
            if ($Usergame->energy <= 0) {
                $Usergame->metal *= 0.4;
                $Usergame->crystal *= 0.4;
                $Usergame->deuterium *= 0.4;
            }
            $Usergame->save();
        }    
        
        return response()->json($Usergame);
    }

    public function updateBuilding(Request $request)
    {
        $buildingID = $request->input('buildingPlanet-id');
        $buildingLevel = $request->input('buildingPlanet-level');
    
        $userID = auth()->id();
        
        $userGame = Usergame::where('user_id', $userID)->first();
        
        $selectedBuilding = buildingPlanet::where('building_id', $buildingID)
            ->where('level', $buildingLevel)->first();
    
        $currentBuildingLevel = buildingLevel::where('building_id', $buildingID)
            ->where('level', $buildingLevel)->first();
    
        $nextBuildingLevel = buildingLevel::where('building_id', $buildingID)
            ->where('level', $buildingLevel + 1)->first();
            
        if ($buildingID == 4) {
            $userGame->energy += $currentBuildingLevel->production_rate;
            $userGame->save();
        }
        if ($nextBuildingLevel && $userGame->metal >= $currentBuildingLevel->metal_cost &&
            $userGame->crystal >= $currentBuildingLevel->crystal_cost &&
            $userGame->deuterium >= $currentBuildingLevel->deuterium_cost) {
            
            $userGame->metal -= $nextBuildingLevel->metal_cost;
            $userGame->crystal -= $nextBuildingLevel->crystal_cost;
            $userGame->deuterium -= $nextBuildingLevel->deuterium_cost;
            $userGame->energy -= $nextBuildingLevel->energy_cost;
            $selectedBuilding->level = $buildingLevel + 1;
            $selectedBuilding->save();
            $userGame->save();
    
            // Devolver un mensaje de éxito o realizar alguna acción adicional si se alcanza el nivel máximo
            // ...
        }
        return redirect()->route('home.index');
    }    
}
