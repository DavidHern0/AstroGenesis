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
use App\Models\Fleet;
use App\Models\Notification;
use App\Models\Defense;
use Carbon\Carbon;
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
                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();

            return view('home.index', [
                'planet' => $planet,
                'userGame' => $userGame,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
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
                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.resources', [
                'planet' => $planet,
                'userGame' => $userGame,
                'buildingPlanets' => $buildingPlanets,
                'buildingLevels' => $buildingLevels,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
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

                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.facilities', [
                'planet' => $planet,
                'userGame' => $userGame,
                'buildingPlanets' => $buildingPlanets,
                'buildingLevels' => $buildingLevels,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
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
            
                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.shipyard', [
                'planet' => $planet,
                'userGame' => $userGame,
                'shipPlanets' => $shipPlanets,
                'shipLevels' => $shipLevels,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
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
            
            $fleets = Fleet::where('user_id', $userID)
                ->where('arrival', '>', Carbon::now()->addSeconds(1))
                ->orderBy('arrival', 'ASC')
                ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.defenses', [
                'planet' => $planet,
                'userGame' => $userGame,
                'defensePlanets' => $defensePlanets,
                'defenseLevels' => $defenseLevels,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function totalAttackFleet($planetID) {

        $totalAttackFleet = [];
        $totalCargo = ShipPlanet::where('planet_id', $planetID)
            ->where('quantity', '>', 0)
            ->whereNotIn('ship_planets.ship_id', [11, 12, 13, 14]) // no Colony Ship / Recycler / Espionage / Solar Satelite
            ->join('ship_levels', 'ship_planets.ship_id', '=', 'ship_levels.ship_id')
            ->selectRaw('SUM(quantity * cargo_capacity) as totalCargo')
            ->value('totalCargo');

        $totalConstructionTime = ShipPlanet::where('planet_id', $planetID)
            ->where('quantity', '>', 0)
            ->whereNotIn('ship_planets.ship_id', [11, 12, 13, 14]) // no Colony Ship / Recycler / Espionage / Solar Satelite
            ->join('ship_levels', 'ship_planets.ship_id', '=', 'ship_levels.ship_id')
            ->selectRaw('SUM(quantity * construction_time) as totalConstruction')
            ->value('totalConstruction');  
            
        $totalAttackFleet = [
            'cargo' => $totalCargo,
            'constructionTime' => $totalConstructionTime
        ];
        return $totalAttackFleet;
    }

    public function fleet()
    {  
        try {
            $userID = auth()->id();
            
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $shipPlanets = ShipPlanet::where('planet_id', $planet->id)->get();
            $shipLevels = ShipLevel::all();

            $totalAttackFleet = self::totalAttackFleet($planet->id);

                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.fleet', [
                'planet' => $planet,
                'userGame' => $userGame,
                'shipPlanets' => $shipPlanets,
                'shipLevels' => $shipLevels,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
                'totalCargo' => $totalAttackFleet['cargo'],
                'totalConstructionTime' => $totalAttackFleet['constructionTime']
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
            $galaxy_position = ($galaxy_position < 1 || $galaxy_position > env('MAX_GALAXY_POS')) ? $planet->galaxy_position : $galaxy_position;
            $planets = Planet::where('galaxy_position', $galaxy_position)
            ->orderByRaw('CAST(solar_system_position AS UNSIGNED) ASC')
            ->get();
            $shipPlanets = ShipPlanet::where('planet_id', $planet->id)
            ->whereNotIn('ship_planets.ship_id', [11, 12, 13, 14])
            ->get();
            $shipLevels = ShipLevel::all();
            $hasShip = $shipPlanets->where('quantity', '>', 0)->whereNotIn('ship_planets.ship_id', [11, 12, 13, 14])->count() > 0;
            
            $totalAttackFleet = self::totalAttackFleet($planet->id);
                
                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.galaxy', [
                'planet' => $planet,
                'planets' => $planets,
                'userGame' => $userGame,
                'galaxy_position' => $galaxy_position,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
                'hasShip' => $hasShip,
                
                'shipPlanets' => $shipPlanets,
                'shipLevels' => $shipLevels,
                'totalCargo' => $totalAttackFleet['cargo'],
                'totalConstructionTime' => $totalAttackFleet['constructionTime']
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function notification()
    {  
        try {
            $userID = auth()->id();
            
            $notifications = Notification::where('user_id', $userID)->get();
            $userGame = userGame::where('user_id', $userID)->first();
            $planet = Planet::where('user_id', $userID)->first();
            $defensePlanets = DefensePlanet::where('planet_id', $planet->id)->get();
                
                        $fleets = Fleet::where('user_id', $userID)
            ->where('arrival', '>', Carbon::now()->addSeconds(1))
            ->orderBy('arrival', 'ASC')
            ->get();
            $unreadNotification = Notification::where('user_id', $userID)
            ->where('read', '0')
            ->orderBy('arrival', 'ASC')
            ->count();
            return view('home.notification', [
                'planet' => $planet,
                'userGame' => $userGame,
                'fleets' => $fleets,
                'unreadNotification' => $unreadNotification,
                'notifications' => $notifications,
                'defensePlanets' => $defensePlanets
            ]);
        } catch(\Exception $e) {
            Log::info('The home page failed to load.', ["error" => $e->getMessage()]);
        }
    }
}