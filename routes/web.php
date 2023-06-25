<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\HomeController;
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
        
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
        
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
    Route::get('/update-resources', [HomeController::class, 'updateResources'])->name('home.update-resources');

    
    Route::post('/update-building', [HomeController::class, 'updateBuilding'])->name('home.update-building');
    Route::post('/update-planetname', [HomeController::class, 'updatePlanetName'])->name('home.update-planetname');

});