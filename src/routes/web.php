<?php

use App\Http\Controllers\AuthController;
use App\Livewire\User\BerandaDiet;
use App\Livewire\User\DaftarBelanjaSaya;
use App\Livewire\User\MakananSaya;
use App\Livewire\User\MealPlanSaya;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('user.dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::get('/home', function () {
    if (Auth::check()) {
        return redirect()->route('user.dashboard');
    }

    return redirect()->route('login');
})->name('home.redirect');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    /*
    |--------------------------------------------------------------------------
    | Google OAuth
    |--------------------------------------------------------------------------
    */

    Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])
        ->name('google.redirect');

    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
        ->name('google.callback');

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])
        ->name('password.request');

    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', BerandaDiet::class)
        ->name('user.dashboard');

    Route::get('/beranda', function () {
        return redirect()->route('user.dashboard');
    })->name('user.beranda.redirect');

    Route::get('/makanan-saya', MakananSaya::class)
        ->name('user.makanan');

    Route::get('/makanan', function () {
        return redirect()->route('user.makanan');
    })->name('user.makanan.redirect');

    Route::get('/meal-plan-saya', MealPlanSaya::class)
        ->name('user.meal-plan');

    Route::get('/meal-plan', function () {
        return redirect()->route('user.meal-plan');
    })->name('user.meal-plan.redirect');

    Route::get('/daftar-belanja-saya', DaftarBelanjaSaya::class)
        ->name('user.daftar-belanja');

    Route::get('/daftar-belanja', function () {
        return redirect()->route('user.daftar-belanja');
    })->name('user.daftar-belanja.redirect');

    Route::get('/profil-saya', function () {
        return view('user.profil-saya-page');
    })->name('user.profil');

    Route::get('/profil', function () {
        return redirect()->route('user.profil');
    })->name('user.profil.redirect');

    Route::get('/profile-saya', function () {
        return redirect()->route('user.profil');
    })->name('user.profile-saya.redirect');

    Route::get('/profile', function () {
        return redirect()->route('user.profil');
    })->name('user.profile.redirect');

    Route::get('/data-user', function () {
        return redirect()->route('user.profil');
    })->name('user.data-user.redirect');
});