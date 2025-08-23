<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planet;
use App\Models\User;
use App\Models\userGame;
use App\Models\Fleet;
use App\Models\DefensePlanet;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{

    public function spy(Request $Request)
    {
        $ssp_otherPlanet = $Request->input('ssp_otherPlanet');
        $gp_otherPlanet = $Request->input('gp_otherPlanet');

        $coordinates = [$ssp_otherPlanet, $gp_otherPlanet];
        $otherPlanet = Planet::where('galaxy_position', $gp_otherPlanet)
            ->where('solar_system_position', $ssp_otherPlanet)
            ->first();


        $otherUserGame = userGame::where('user_id', $otherPlanet->user_id)->first();
        $otherDefenses = DefensePlanet::where('planet_id', $otherPlanet->id)->get();
        $resources = [];
        $resources[0] = round($otherUserGame->metal);
        $resources[1] = round($otherUserGame->crystal);
        $resources[2] = round($otherUserGame->deuterium);

        $defense = [];
        foreach ($otherDefenses as $i => $otherDefense) {
            $defense[$i] = $otherDefense->quantity;
        }
        $notification = Notification::notificationSpy($resources, $defense, $coordinates);
    }

    public function fleet(Request $Request)
    {
        $resources         = $Request->session()->get('exp_resources');
        $fleetID           = $Request->input('fleetID');
        $fleetType         = $Request->input('fleetType');
        $attack_fleet_data = $Request->session()->get("attack_fleet_$fleetID");
        $attack_result_data = $Request->session()->get("attack_result_$fleetID");

        if ($fleetType == 'attack') {
            $userID = auth()->id();
            $UserUserGame = userGame::where('user_id', $userID)->first();

            $resourcesLooted   = $attack_result_data['resourcesLooted'];
            $destroyedDefenses = $attack_result_data['destroyedDefenses'];
            $otherPlanetID     = $attack_result_data['otherPlanetID'];
            $totalLost         = $attack_result_data['totalLost'];

            $userPlanet    = $otherPlanetID ? Planet::where('id', $otherPlanetID)->first() : null;
            $otherUserGame = $userPlanet ? userGame::where('user_id', $userPlanet->user_id)->first() : null;

            Notification::notificationAttack(
                array_values($resourcesLooted ?? []),
                array_values($destroyedDefenses ?? []),
                $attack_fleet_data['coordinates'] ?? [],
                $totalLost
            );    

            if ($otherUserGame && !empty($resourcesLooted)) {
                $otherUserGame->metal -= $resourcesLooted['metal'] ?? 0;
                $otherUserGame->crystal -= $resourcesLooted['crystal'] ?? 0;
                $otherUserGame->deuterium -= $resourcesLooted['deuterium'] ?? 0;
                $otherUserGame->save();
            }

            if ($UserUserGame && !empty($resourcesLooted)) {
                $UserUserGame->metal     += ($resourcesLooted['metal'] ?? 0);
                $UserUserGame->crystal   += ($resourcesLooted['crystal'] ?? 0);
                $UserUserGame->deuterium += ($resourcesLooted['deuterium'] ?? 0);
                $UserUserGame->save();
            }

            $Request->session()->forget('resourcesLooted');
            $Request->session()->forget('destroyedDefenses');
            $Request->session()->forget('otherPlanetID');
            $Request->session()->forget('totalLost');
            
            $Request->session()->forget("attack_fleet_$fleetID");
            $Request->session()->forget("attack_result_$fleetID");
        }
        // Expedición
        if ($fleetType == 'expedition') {
            if ($resources) {
                Notification::notificationExpedition($resources);
            }
            $Request->session()->forget('expedition');
            $Request->session()->forget('exp_resources');
        } 

        if ($fleetID) {
            Fleet::recoverFromExpedition($fleetID);
        }
    }


    public function read($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->read = 1;
            $notification->save();

            if ($notification->type === 'expedition') {
                $userID = auth()->id();
                $userGame = userGame::where('user_id', $userID)->first();
                $resources = json_decode($notification->resources);
                $userGame->metal = min($userGame->metal + $resources[0], $userGame->metal_storage);
                $userGame->crystal = min($userGame->crystal + $resources[1], $userGame->crystal_storage);
                $userGame->deuterium = min($userGame->deuterium + $resources[2], $userGame->deuterium_storage);
                $userGame->save();
            }

            return response()->json(['message' => 'Notification read successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return response()->json(['message' => 'Deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
