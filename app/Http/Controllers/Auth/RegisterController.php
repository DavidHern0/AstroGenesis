<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {  
        try {
            // if(auth()->user()) {
            //     return redirect()->route('user.edit');
            // }else{
            //     return view('register.index');
            // }
            return view('auth.register.index');
        } catch(\Exception $e) {
            Log::info('The register page failed to load.', ["error" => $e->getMessage()]);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6|same:password_confirmation',
                'password_confirmation' => 'required|string|min:6|same:password',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::create([
                'name' => $validator->validated()['name'],
                'email' => $validator->validated()['email'],
                'password' => Hash::make($validator->validated()['password']),
            ]);

            return redirect()->route('login.index');
        } catch(\Exception $e) {
            Log::info('The registration failed.', ["error" => $e->getMessage()]);
        }
    }
}
