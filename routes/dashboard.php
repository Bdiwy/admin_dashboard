<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

// Authenticated Routes (Dashboard)
Route::prefix('dashboard')->middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('/', 'home')->name('dashboard');
    Route::get('/billing', 'billing')->name('billing');
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/user-management', 'userManagement')->name('user-management');
    Route::get('/tables', 'tables')->name('tables');
    Route::get('/user-profile', 'userProfile')->name('profile.create');
    Route::post('/user-profile', 'storeProfile')->name('profile.store');
    // Logout moved outside dashboard prefix for consistency
});

