<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {  
        try {
            if(auth()->user()) {
                return redirect()->route('home.index');
            }else{
                return view('landing.index');
            }
        } catch(\Exception $e) {
            Log::info('The landing page failed to load.', ["error" => $e->getMessage()]);
        }
    }
}
