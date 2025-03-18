<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\Auth\GuestController;
use App\Http\Controllers\Dashboard\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes
Route::middleware('guest')->controller(GuestController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store');
    Route::get('/login', 'login.store')->name('login');
    Route::get('/forgot-password', 'forgotPassword')->name('password.request');
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'resetPassword')->name('password.reset');
    Route::post('/reset-password', 'updatePassword')->name('password.update');
});

// Dashboard Routes (Authenticated)
Route::prefix('dashboard')->middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('/', 'home')->name('dashboard');
    Route::get('/billing', 'billing')->name('billing');
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/rtl', 'rtl')->name('rtl');
    Route::get('/user-management', 'userManagement')->name('user-management');
    Route::get('/tables', 'tables')->name('tables');
    Route::get('/virtual-reality', 'virtualReality')->name('virtual-reality');
    Route::get('/user-profile', 'userProfile')->name('profile.create');
    Route::post('/user-profile', 'storeProfile')->name('profile.store');
    Route::post('/logout', 'logout')->name('logout');
});

// Static Routes
Route::controller(StaticController::class)->group(function () {
    Route::get('/static-sign-in', 'signIn')->name('static.sign-in');
    Route::get('/static-sign-up', 'signUp')->name('static.sign-up');
});


// App Routes
Route::get('/', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/search', [HotelController::class, 'search'])->name('hotels.search');
Route::post('/bookings', [HotelController::class, 'storeBooking'])->name('bookings.store');