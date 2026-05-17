<?php

use App\Http\Controllers\Auth\AuthController;
use App\Livewire\User\BerandaDiet;
use App\Livewire\User\DaftarBelanjaSaya;
use App\Livewire\User\MakananSaya;
use App\Livewire\User\MealPlanSaya;
use App\Livewire\User\ProfileSaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('user.beranda');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/beranda', BerandaDiet::class)
        ->name('user.beranda');

    Route::get('/makanan-saya', MakananSaya::class)
        ->name('user.makanan-saya');

    Route::get('/meal-plans', MealPlanSaya::class)
        ->name('user.meal-plans');

    Route::get('/daftar-belanja', DaftarBelanjaSaya::class)
        ->name('user.daftar-belanja');

    Route::get('/profile', ProfileSaya::class)
        ->name('user.profile');

    Route::get('/dashboard', function () {
        return redirect()->route('user.beranda');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});