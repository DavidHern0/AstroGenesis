<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\userGame;
use App\Models\BuildingPlanet;
use App\Models\BuildingLevel;
use App\Models\Ship;
use App\Models\ShipPlanet;
use App\Models\ShipLevel;
use App\Models\DefensePlanet;
use App\Models\DefenseLevel;
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

    public function shipyard()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $shipPlanets = ShipPlanet::where('planet_id', $planet->id)->get();
            $shipLevels = ShipLevel::all();
            return view('home.shipyard', [
                'planet' => $planet,
                'userGame' => $userGame,
                'shipPlanets' => $shipPlanets,
                'shipLevels' => $shipLevels,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function defenses()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $defensePlanets = DefensePlanet::where('planet_id', $planet->id)->get();
            $defenseLevels = DefenseLevel::all();
            return view('home.defenses', [
                'planet' => $planet,
                'userGame' => $userGame,
                'defensePlanets' => $defensePlanets,
                'defenseLevels' => $defenseLevels,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function fleet()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $shipPlanets = ShipPlanet::where('planet_id', $planet->id)->get();
            $shipLevels = ShipLevel::all();
            return view('home.fleet', [
                'planet' => $planet,
                'userGame' => $userGame,
                'shipPlanets' => $shipPlanets,
                'shipLevels' => $shipLevels,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function galaxy($galaxy_position)
    {  
        try {
            $userID = auth()->id();
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $planets = Planet::where('galaxy_position', $galaxy_position)
                ->orderByRaw('CAST(solar_system_position AS UNSIGNED) ASC')
                ->get();
            return view('home.galaxy', [
                'planet' => $planet,
                'planets' => $planets,
                'userGame' => $userGame,
                'galaxy_position' => $galaxy_position,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }
}