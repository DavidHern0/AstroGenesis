<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {  
        try {
            if(auth()->user()) {
                return redirect()->route('home.index');
            }else{
                return view('auth.login.index');
            }
        } catch(\Exception $e) {
            Log::info('The login page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                return redirect()->route('home.index');
            }
            return back()->withErrors([
                'email' => 'The email or password are wrong.',
            ]);
        } catch(\Exception $e) {
            Log::info('The login page failed to load.', ["error" => $e->getMessage()]);
        }
    }
}
