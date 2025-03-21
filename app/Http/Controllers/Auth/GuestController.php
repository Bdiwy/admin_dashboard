<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    private $root = 'website';
    public function home()
    {
        return view('website.index');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Registration logic (use Laravel's built-in if preferred)
    }

    public function login()
    {
        return view('session.login-session');
    }

    public function authenticate(Request $request)
    {
        // Authentication logic
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        // Password reset link logic
    }

    public function resetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        // Update password logic
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('hotels.index');
    }
}