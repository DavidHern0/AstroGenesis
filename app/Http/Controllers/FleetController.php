<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Planet;
use App\Models\User;
use App\Models\userGame;
use App\Models\ShipPlanet;
use App\Models\Notification;
use App\Models\DefensePlanet;
use App\Models\Defense;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

class FleetController extends Controller
{
    public function spy_action($otherPlanet) {
        $otherUserGame = UserGame::where('user_id', $otherPlanet->user_id)->first();
        $otherDefenses = DefensePlanet::where('planet_id', $otherPlanet->id)->get();


        LOG::INFO("Metal: ".round($otherUserGame->metal));
        LOG::INFO("Cristal: ".round($otherUserGame->crystal));
        LOG::INFO("Deuterio: ".round($otherUserGame->deuterium));
        foreach ($otherDefenses as $otherDefense) {
            LOG::INFO($otherDefense->defense->getTranslation('name', config('app.locale')) .": ".$otherDefense->quantity);
        }
        $notification = Notification::spyNotification(auth()->id(), $otherPlanet);
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
            $this->spy_action($otherPlanet);
            return redirect()->route("home.galaxy", $galaxyID)->with('success', __("spy_succes"));
        } else {
        return redirect()->route("home.galaxy", $galaxyID)->with('error', __("spy_error"));
        }
    }
}
