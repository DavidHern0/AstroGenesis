<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Planet;
use App\Models\User;
use App\Models\userGame;
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
        // ->where('solar_system_position', $ssp_otherPlanet)
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

        $resources = $Request->session()->get('exp_resources');

        Notification::notificationExpedition($resources);
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
            return response()->json(['message' => 'Notification readed succesfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::findOrFail($id);            
            $notification->delete();
            
            return response()->json(['message' => 'Deleted succesfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }
    
}
