<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LocaleMiddleware;


Route::get('/locale/{locale}', function ($locale) {
    return redirect()->back()->withCookie('locale', $locale);
})->name('locale');

Route::middleware(LocaleMiddleware::class)->group(function () {
    Route::get('/', [LandingController::class, 'index'])->name('landing.index');
    
    Route::get('/home', [HomeController::class, 'index'])->name('home.index')
    ->middleware('auth');
    Route::get('/home/resources', [HomeController::class, 'resources'])->name('home.resources')
    ->middleware('auth');
    Route::get('/home/facilities', [HomeController::class, 'facilities'])->name('home.facilities')
    ->middleware('auth');
    Route::get('/home/shipyard', [HomeController::class, 'shipyard'])->name('home.shipyard')
    ->middleware('auth');
    Route::get('/home/galaxy/{galaxy_position}', [HomeController::class, 'galaxy'])->name('home.galaxy')
    ->middleware('auth');
    Route::get('/home/defenses', [HomeController::class, 'defenses'])->name('home.defenses')
    ->middleware('auth');

    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
        
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
    Route::get('/update-resources', [UserController::class, 'updateResources'])->name('home.update-resources');
    Route::get('/update-all', [UserController::class, 'updateAll'])->name('home.update-all');

    
    Route::post('/update-building', [UserController::class, 'updateBuilding'])->name('home.update-building');
    Route::post('/update-ship', [UserController::class, 'updateShip'])->name('home.update-ship');
    Route::post('/update-defense', [UserController::class, 'updateDefense'])->name('home.update-defense');
    Route::post('/update-planetname', [UserController::class, 'updatePlanetName'])->name('home.update-planetname');

});