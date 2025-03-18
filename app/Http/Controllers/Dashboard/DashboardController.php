<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home()
    {
        return view('dashboard');
    }

    public function billing()
    {
        return view('billing');
    }

    public function profile()
    {
        return view('profile');
    }

    public function rtl()
    {
        return view('rtl');
    }

    public function userManagement()
    {
        return view('laravel-examples.user-management');
    }

    public function tables()
    {
        return view('tables');
    }

    public function virtualReality()
    {
        return view('virtual-reality');
    }

    public function userProfile()
    {
        return view('dashboard.user-profile'); // Assuming this view
    }

    public function storeProfile(Request $request)
    {
        // Store profile logic
    }

    public function logout(Request $request)
    {
        // Logout logic
    }
}