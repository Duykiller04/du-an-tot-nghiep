<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHER_API_KEY');
        $this->baseUrl = 'https://api.openweathermap.org/data/2.5/weather';
    }

    public function getWeatherData($latitude, $longitude)
    {
        $response = Http::get($this->baseUrl, [
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $this->apiKey,
            'units' => 'metric' // Đơn vị tính là độ C
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getTemperature($latitude, $longitude)
    {
        $data = $this->getWeatherData($latitude, $longitude);
        return $data ? $data['main']['temp'] : null;
    }

    public function getHumidity($latitude, $longitude)
    {
        $data = $this->getWeatherData($latitude, $longitude);
        return $data ? $data['main']['humidity'] : null;
    }
}
