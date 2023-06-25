<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\userGame;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{
    public function index()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            return view('home.index', [
                'planet' => $planet,
                'userGame' => $userGame,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function resources()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $buildingPlanets = BuildingPlanet::where('planet_id', $planet->id)->where('type', "resources")->get();
            $buildingLevels = BuildingLevel::all();
            return view('home.resources', [
                'planet' => $planet,
                'userGame' => $userGame,
                'buildingPlanets' => $buildingPlanets,
                'buildingLevels' => $buildingLevels,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function facilities()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $buildingPlanets = BuildingPlanet::where('planet_id', $planet->id)->where('type', "facilities")->get();
            $buildingLevels = BuildingLevel::all();
            return view('home.facilities', [
                'planet' => $planet,
                'userGame' => $userGame,
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
        
        $userGame = userGame::where('user_id', $userID)->first();
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
        

        // BOOST ////////////////////////////////////////////////////////
        $metal_production *= 10;
        $crystal_production *= 10;
        $deuterium_production *= 10;
        /////////////////////////////////////////////////////////////////

        if ($userGame->energy < 0) {
            $metal_production *= 0.4;
            $crystal_production *= 0.4;
            $deuterium_production *= 0.4;
        }

        if ($userGame) {
            if ($metal_production) {
                $metal_production_per_hour = ($metal_production + 40) / 3600;
                if ($userGame->metal < $userGame->metal_storage) {
                    $userGame->metal += $metal_production_per_hour * 5;
                }
            }
            if ($crystal_production) {
                $crystal_production_per_hour = ($crystal_production + 15) / 3600;
                if ($userGame->crystal < $userGame->crystal_storage) {
                    $userGame->crystal += $crystal_production_per_hour * 5;
                }
            }
            if ($deuterium_production) {
                $deuterium_production_per_hour = ($deuterium_production + 15) / 3600;
                if ($userGame->deuterium < $userGame->deuterium_storage) {
                    $userGame->deuterium += $deuterium_production_per_hour * 5;
                }
            }
            $userGame->save();
        }    
        
        return response()->json($userGame);
    }

    public function updateBuilding(Request $request)
    {
        $buildingID = $request->input('buildingPlanet-id');
        $buildingLevel = $request->input('buildingPlanet-level');
    
        $userID = auth()->id();
        
        $userGame = userGame::where('user_id', $userID)->first();
        
        $selectedBuilding = buildingPlanet::where('building_id', $buildingID)
            ->where('level', $buildingLevel)->first();
    
        $currentBuildingLevel = buildingLevel::where('building_id', $buildingID)
            ->where('level', $buildingLevel)->first();
    
        $nextBuildingLevel = buildingLevel::where('building_id', $buildingID)
            ->where('level', $buildingLevel + 1)->first();
            
            if ($nextBuildingLevel && $userGame->metal >= $currentBuildingLevel->metal_cost &&
            $userGame->crystal >= $currentBuildingLevel->crystal_cost &&
            $userGame->deuterium >= $currentBuildingLevel->deuterium_cost) {
                if ($buildingID == 4) {
                    $userGame->energy += $currentBuildingLevel->production_rate;
                }
                else if ($buildingID == 5) {
                    $userGame->metal_storage += $currentBuildingLevel->production_rate;
                }
                else if ($buildingID == 6) {
                    $userGame->crystal_storage += $currentBuildingLevel->production_rate;
                }
                else if ($buildingID == 7) {
                    $userGame->deuterium_storage += $currentBuildingLevel->production_rate;
                }
                $userGame->metal -= $currentBuildingLevel->metal_cost;
                $userGame->crystal -= $currentBuildingLevel->crystal_cost;
                $userGame->deuterium -= $currentBuildingLevel->deuterium_cost;
                $userGame->energy -= $currentBuildingLevel->energy_cost;
                $selectedBuilding->level = $buildingLevel + 1;
                $selectedBuilding->save();
                $userGame->save();
            // Devolver un mensaje de éxito o realizar alguna acción adicional si se alcanza el nivel máximo
            // ...
            if ($userGame->energy < 0) {
                return redirect()->route("home.$selectedBuilding->type")->with('success', __("update_succes"))->with('error', __("insufficient_energy"));
            }
            return redirect()->route("home.$selectedBuilding->type")->with('success', __("update_success"));
        } else{
            $building = $selectedBuilding->building;
            return redirect()->route("home.$selectedBuilding->type")->with('error', __("update_error"));

        }
    }    
    public function updatePlanetName(Request $request)
    {
        $newTitle = $request->input('planetName');
    
        $planet = Planet::where('user_id', auth()->id())->first();
    
        if ($planet) {
            $planet->name = $newTitle;
            $planet->save();
    
            return response()->json(['success' => true, 'message' => 'Título actualizado correctamente']);
        }
    
        return response()->json(['success' => false, 'message' => 'No se encontró el planeta del usuario']);
    }
}