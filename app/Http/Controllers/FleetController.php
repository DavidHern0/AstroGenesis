<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\Planet;
use App\Models\User;
use App\Models\userGame;
use App\Models\ShipLevel;
use App\Models\ShipPlanet;
use App\Models\DefensePlanet;
use App\Models\Defense;
use App\Models\Fleet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

class FleetController extends Controller
{
    public function spy(Request $Request)
    {  
        $planetID = $Request->input('planet-id');
        $galaxyID = $Request->input('galaxy-id');
        $userID = auth()->id();
        
        $userGame = userGame::where('user_id', $userID)->first();
        $planet = Planet::where('user_id', $userID)->first();
        $otherPlanet = Planet::where('id', $planetID)->first();
        $spyProbes = ShipPlanet::where('planet_id', $planet->id)->where('ship_id', 13)->first();

        if ($spyProbes->quantity > 0) {
            $spyProbes->quantity--;
            $spyProbes->save();
            $spy = Fleet::createSpy($otherPlanet);
            return redirect()->route("home.galaxy", $galaxyID)->with('success', __("spy_succes"));
        } else {
        return redirect()->route("home.galaxy", $galaxyID)->with('error', __("spy_error"));
        }
    }

    
    public function send(Request $Request)
    {
        $typeSend = $Request->input('type');
        $shipPlanet_ids = $Request->input('shipPlanet_id');
        $ship_numbers = $Request->input('ship_number');
        if (min($ship_numbers) >= 0) {
            $shipsSent = [];

            foreach ($shipPlanet_ids as $i => $shipPlanet_id) {
                $ship_number = $ship_numbers[$i];
                $shipsSent[] = [$shipPlanet_id, $ship_number];
            }
            ShipPlanet::subtractShipsSent($shipPlanet_ids, $ship_numbers);
            switch ($typeSend) {
                case 'expedition':
                    $expedition_hours = $Request->input('expedition_hours');
                    Fleet::expedition($shipPlanet_ids, $ship_numbers,$expedition_hours);
                    
                    // $random = rand(1,100);
                    $random = 80;
                    if ($random <= 10) {
                        # loss of fleet...
                    } else if($random > 10 && $random <= 40){
                        # nothing...
                    } else {
                        # resources...
                        
                        $shipCargo = 0;
                        foreach ($shipPlanet_ids as $i => $shipPlanet_id) {
                            $shipLevel = ShipLevel::where('ship_id', $shipPlanet_id)->first();
                            $shipCargo += $shipLevel->cargo_capacity * $ship_numbers[$i];
                        }
                        
                        
                        $minCargo = max(1, $shipCargo * 0.1);
                        $maxCargo = min($shipCargo, $shipCargo * 0.9 * min(1, $expedition_hours/24));
                        $randomCargo = rand($minCargo, $maxCargo);
                        
                        $metal = round($randomCargo * 0.60);
                        $crystal = round($randomCargo * 0.30);
                        $deuterium = round($randomCargo - $metal - $crystal);

                        // ±5% variation
                        $metal = round($metal * (0.95 + rand(0, 10)/100));
                        $crystal = round($crystal * (0.95 + rand(0, 10)/100));
                        $deuterium = round($deuterium * (0.95 + rand(0, 10)/100));
                        
                        $exp_resources = [$metal, $crystal, $deuterium];
                        session(['exp_resources' => $exp_resources]);
                    }
                    return redirect()->route("home.fleet")->with('success', __("fleet_succes"));
                break;
                    
                case 'attack':
                    $planet_ssp = $Request->input('planet_ssp');
                    $planet_gp = $Request->input('planet_gp');
                    $otherPlanet = Planet::where('solar_system_position', $planet_ssp)
                    ->where('galaxy_position', $planet_gp)
                    ->first();
                    if ($otherPlanet) {
                        Fleet::sendFleet($shipPlanet_ids, $ship_numbers, $otherPlanet);
                        return redirect()->route("home.fleet")->with('success', __("fleet_succes"));
                    } else {
                        return redirect()->route("home.fleet")->with('success', __("fleet_error"));
                    }
                break;
                        
                case 'resource_transport':
                # code...
                break;
                
                default:
                # code...
                break;
            }
        } else {
            return redirect()->route("home.fleet")->with('error', __("update_error_negative"));
        }
    }
}