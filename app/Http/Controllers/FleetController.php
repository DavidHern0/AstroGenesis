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
    public function attack(Request $Request, $adjustedNumbers, $fleetID)
    {
        $planetID = $Request->input('planet-id');
        $galaxyID = $Request->input('galaxy-id');
        $otherPlanet = Planet::where('id', $planetID)->first();

        $coordinates = [$otherPlanet->solar_system_position, $otherPlanet->galaxy_position];

        $otherUserGame = userGame::where('user_id', $otherPlanet->user_id)->first();
        $otherDefenses = DefensePlanet::where('planet_id', $otherPlanet->id)->get();

        $resources = [
            round($otherUserGame->metal),
            round($otherUserGame->crystal),
            round($otherUserGame->deuterium),
        ];

        $defense = [];
        foreach ($otherDefenses as $i => $otherDefense) {
            $defense[$i] = $otherDefense->quantity;
        }





        $userID = auth()->id();
        $userPlanet = Planet::where('user_id', $userID)->first();
        $userShips = ShipPlanet::where('planet_id', $userPlanet->id)
            ->where('quantity', '!=', 0)
            ->whereNotIn('id', [11, 12, 13, 14]) // no Colony Ship / Recycler / Espionage / Solar Satelite
            ->get();
            if ($userShips->isEmpty()) {
                return redirect()->route("home.galaxy", $galaxyID)->with('error', __("attack_error"));
            } else {
                $shipPlanet_ids = $userShips->pluck('id')->toArray();
                $ship_numbers = $adjustedNumbers;

                $attack_fleet_data = [
                        'resources' => $resources,
                        'defenses' => $defense,
                        'coordinates' => $coordinates,
                        'shipPlanet_ids' => $shipPlanet_ids,
                        'ship_numbers' => $ship_numbers
                ];

                foreach (session()->all() as $key => $value) {
                    if (str_starts_with($key, 'attack-')) {
                        session()->forget($key);
                    }
                }
                $Request->session()->put("attack_fleet_$fleetID", $attack_fleet_data);
                Fleet::attackPlanet($Request, $shipPlanet_ids, $ship_numbers, $otherPlanet, $fleetID);
                return;
            }
    }



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
        $userID = auth()->id();

        $lastFleet = Fleet::where('user_id', $userID)->orderBy('id', 'desc')->first();
        if ($lastFleet) {
        $fleetID = ($lastFleet->id)+1;
        } else {
         $fleetID = 1;   
        }
        $galaxyID = $Request->input('galaxy-id');
        $typeSend = $Request->input('type');
        $shipPlanet_ids = $Request->input('shipPlanet_id');

        $ship_numbers = $Request->input('ship_number');   
        $adjustedNumbers = [];
        foreach ($shipPlanet_ids as $i => $shipPlanet_id) {
            if (in_array($shipPlanet_id, [11, 12, 13, 14])) {
                $adjustedNumbers[] = 0;
            } else {
                $adjustedNumbers[] = $ship_numbers[$i];
            }
        }
        $allZero = count(array_filter($adjustedNumbers, fn($num) => $num != 0)) === 0;
        if ((count(array_unique($ship_numbers)) != 1 || max($ship_numbers) > 0) && !$allZero) {

            switch ($typeSend) {
                case 'expedition':
                    $expedition_hours = $Request->input('expedition_hours');
                    Fleet::expedition($shipPlanet_ids, $adjustedNumbers, $expedition_hours);

                    // $random = rand(1,100);
                    $random = 80;
                    if ($random <= 10) {
                        # loss of fleet...
                    } else if ($random > 10 && $random <= 40) {
                        # nothing...
                    } else {
                        # resources...

                        $shipCargo = 0;
                        foreach ($shipPlanet_ids as $i => $shipPlanet_id) {
                            $shipLevel = ShipLevel::where('ship_id', $shipPlanet_id)->first();
                            $shipCargo += $shipLevel->cargo_capacity * $ship_numbers[$i];
                        }


                        $minCargo = max(1, $shipCargo * 0.1);
                        $maxCargo = min($shipCargo, $shipCargo * 0.9 * min(1, $expedition_hours / 24));
                        $randomCargo = rand($minCargo, $maxCargo);

                        $metal = round($randomCargo * 0.60);
                        $crystal = round($randomCargo * 0.30);
                        $deuterium = round($randomCargo - $metal - $crystal);

                        // ±5% variation
                        $metal = round($metal * (0.95 + rand(0, 10) / 100));
                        $crystal = round($crystal * (0.95 + rand(0, 10) / 100));
                        $deuterium = round($deuterium * (0.95 + rand(0, 10) / 100));

                        $exp_resources = [$metal, $crystal, $deuterium];
                        session(['exp_resources' => $exp_resources]);
                    }
                    
                    ShipPlanet::subtractShipsSent($shipPlanet_ids, $adjustedNumbers);
                    return redirect()->route("home.fleet")->with('success', __("fleet_succes"));
                    break;

                case 'attack':
                    self::attack($Request, $adjustedNumbers, $fleetID);
                    ShipPlanet::subtractShipsSent($shipPlanet_ids, $adjustedNumbers);
                    return redirect()->route("home.galaxy", $galaxyID)->with('success', __("attack_succes"));
                    break;

                case 'resource_transport':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            return redirect()->route("home.fleet")->with('error', __("expedition_error"));
        }
    }
}
