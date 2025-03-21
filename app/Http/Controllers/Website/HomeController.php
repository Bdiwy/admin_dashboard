<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $rooms = [
            ['id' => 1, 'name' => 'Superior Room', 'description' => 'Luxurious and spacious.', 'price' => 250],
            ['id' => 2, 'name' => 'Deluxe Suite', 'description' => 'Elegant with a view.', 'price' => 350],
            ['id' => 3, 'name' => 'Family Room', 'description' => 'Perfect for groups.', 'price' => 400],
        ];

        return view('index', compact('rooms'));
    }

    public function checkAvailability(Request $request)
    {
        // Placeholder for booking logic
        $request->validate([
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
        ]);

        return redirect()->route('home')->with('success', 'Availability checked!');
    }
}