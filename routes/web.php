<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GuestController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\HotelController;
use App\Http\Controllers\Website\StaticController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (Unauthenticated Users)
Route::middleware('guest')->controller(GuestController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store');
    Route::get('/login', 'login')->name('login'); // Fixed: 'login' not 'login.store'
    Route::post('/session', 'authenticate')->name('login.store'); // POST for login submission
    Route::get('/forgot-password', 'forgotPassword')->name('password.request');
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'resetPassword')->name('password.reset');
    Route::post('/reset-password', 'updatePassword')->name('password.update');
});

// Static Routes (Optional)
Route::controller(StaticController::class)->group(function () {
    Route::get('/static-sign-in', 'signIn')->name('static.sign-in');
    Route::get('/static-sign-up', 'signUp')->name('static.sign-up');
});

// Public App Routes (Crowny Hotel)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/bookings/check', [HomeController::class, 'checkAvailability'])->name('bookings.check');

// Logout (Authenticated Users)
Route::post('/logout', [GuestController::class, 'logout'])->name('logout')->middleware('auth');

// Optional HotelController Routes (TravelFinder, if still needed)
Route::group(['prefix' => 'hotels'], function () {
    Route::get('/', [HotelController::class, 'index'])->name('hotels.index');
    Route::get('/search', [HotelController::class, 'search'])->name('hotels.search');
    Route::post('/bookings', [HotelController::class, 'storeBooking'])->name('bookings.store');
});
