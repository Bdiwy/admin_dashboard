<?php

namespace App\Http\Controllers;

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