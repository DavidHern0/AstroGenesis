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
        $attack_fleet_data = $Request->session()->get('attack_fleet_data');
        $resources = $Request->session()->get('exp_resources');

        if ($attack_fleet_data) {

            $userID = auth()->id();
            $UserUserGame = userGame::where('user_id', $userID)->first();
            $resourcesLooted = $Request->session()->get('resourcesLooted');
            $otherPlanetID = $Request->session()->get('otherPlanetID');
            $userPlanet = Planet::where('id', $otherPlanetID)->first();
            $otherUserGame = userGame::where('user_id', $userPlanet->user_id)->first();
            
            Notification::notificationAttack(
                array_values($resourcesLooted),
                $attack_fleet_data['defenses'],
                $attack_fleet_data['coordinates']
            );
            $Request->session()->forget('attack_fleet_data');

            $otherUserGame->metal -= $resourcesLooted['metal'];
            $otherUserGame->crystal -= $resourcesLooted['crystal'];
            $otherUserGame->deuterium -= $resourcesLooted['deuterium'];
            $otherUserGame->save();

            // Restar recursos del planeta atacado
            $UserUserGame->metal += $resourcesLooted['metal'];
            $UserUserGame->crystal += $resourcesLooted['crystal'];
            $UserUserGame->deuterium += $resourcesLooted['deuterium'];
            $UserUserGame->save();

            $Request->session()->forget('resourcesLooted');
            $Request->session()->forget('otherPlanetID');
        } else {
            Notification::notificationExpedition($resources);
        }

        Fleet::recoverFromExpedition();
        $Request->session()->forget('exp_resources');
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
                $userGame->metal += $resources[0];
                $userGame->crystal += $resources[1];
                $userGame->deuterium += $resources[2];
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
