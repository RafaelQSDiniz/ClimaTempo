<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenWeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(protected OpenWeatherService $openWeather) {}

    public function byCity(Request $request)
    {
        $validated = $request->validate([
            'city'  => 'required|string',
            'state' => 'required|string|size:2',
        ]);

        $result = $this->openWeather->getWeatherByCity(
            $validated['city'],
            $validated['state']
        );

        if (!$result) {
            return response()->json(['message' => 'Local não encontrado'], 404);
        }

        return response()->json($result);
    }
}
