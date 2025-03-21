<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;

class StaticController extends Controller
{
    public function signIn()
    {
        return view('static-sign-in');
    }

    public function signUp()
    {
        return view('static-sign-up');
    }
}