<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function index(Request $request)
{
    $apiKey = env('OPENWEATHER_API_KEY');

    $lat = $request->input('lat');
    $lon = $request->input('lon');
    $city = $request->input('city');

    if ($lat && $lon) {
        // Request by coordinates
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);
    } else {
        // Default or city input
        $city = $city ?? 'Lahore';
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);
    }

    if ($response->successful()) {
        $weather = $response->json();
        $city = $weather['name']; // Update detected city
        return view('weather', compact('weather', 'city'));
    } else {
        return view('weather', ['error' => 'API Error: ' . $response->status()]);
    }
}

}
