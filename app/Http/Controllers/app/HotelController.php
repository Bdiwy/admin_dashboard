<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = [
            [
                'name' => 'Luxury Resort & Spa',
                'price' => 150,
                'rating' => 4,
                'amenities' => ['wifi', 'pool'],
                'image' => 'https://via.placeholder.com/300x200',
            ],
            // Add more default hotels as needed
        ];

        return view('hotels.index', [
            'hotels' => $hotels,
            'hotelDescription' => 'A luxurious resort offering premium amenities and exceptional service.',
        ]);
    }

    public function search(Request $request)
    {
        $hotels = $this->filterHotels($request);
        return view('hotels.index', [
            'hotels' => $hotels,
            'hotelDescription' => 'Search results for your perfect stay.',
        ]);
    }

    public function storeBooking(Request $request)
    {
        // Validate and store booking
        $request->validate([
            'hotel_id' => 'required',
            'checkin' => 'required|date',
            'checkout' => 'required|date|after:checkin',
        ]);

        // Booking logic here
        return redirect()->route('hotels.index')->with('success', 'Booking successful!');
    }

    private function filterHotels(Request $request)
    {
        $hotels = [
            // Same default hotels as in index
            [
                'name' => 'Luxury Resort & Spa',
                'price' => 150,
                'rating' => 4,
                'amenities' => ['wifi', 'pool'],
                'image' => 'https://via.placeholder.com/300x200',
            ],
        ];

        // Implement filtering logic based on request parameters
        return array_filter($hotels, function ($hotel) use ($request) {
            $priceMin = $request->input('price_min', 0);
            $priceMax = $request->input('price_max', 500);
            $ratings = $request->input('rating', []);
            $amenities = $request->input('amenities', []);

            return $hotel['price'] >= $priceMin &&
                   $hotel['price'] <= $priceMax &&
                   (empty($ratings) || in_array($hotel['rating'], $ratings)) &&
                   (empty($amenities) || !array_diff($amenities, $hotel['amenities']));
        });
    }
}