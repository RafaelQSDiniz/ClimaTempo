<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenWeatherService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    public function geocode(string $city, string $state): ?array
    {
        $response = Http::get('https://api.openweathermap.org/geo/1.0/direct', [
            'q'     => "{$city},{$state},BR",
            'limit' => 1,
            'appid' => $this->apiKey,
        ]);

        $data = $response->json();

        return $data[0] ?? null;
    }

    public function getCurrentWeather(float $lat, float $lon): array
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat'   => $lat,
            'lon'   => $lon,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang'  => 'pt_br',
        ]);

        return $response->json();
    }

    public function getWeatherByCity(string $city, string $state): ?array
    {
        $location = $this->geocode($city, $state);

        if (!$location) {
            return null;
        }

        return [
            'location' => [
                'name'  => $location['name'],
                'state' => $location['state'] ?? $state,
                'lat'   => $location['lat'],
                'lon'   => $location['lon'],
            ],
            'weather' => $this->getCurrentWeather($location['lat'], $location['lon']),
        ];
    }
}
