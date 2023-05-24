<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Exception;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'weather_today', 'weather_tomorrow', 'weather_updated_at'];

    public function __toString()
    {
        return "Processed city {$this->name} (#id={$this->id}) | {$this->weather_today} - {$this->weather_tomorrow}";
    }

    public static function getWeatherByApi(string $cityName, bool $saveToDB)
    {
        $token = config('weatherapi.token');
        $response = Http::get("http://api.weatherapi.com/v1/forecast.json?key={$token}&q={$cityName}}&days=2&aqi=no&alerts=no");

        if ($response->getStatusCode() != 200) {
            throw new Exception;
        }

        $response = json_decode($response, TRUE);

        $city = City::whereName($cityName)->first();
        if (empty($city)) {
            $city = City::make();
            $city->name = $cityName;
        }

        $city->weather_today = $response['forecast']['forecastday'][0]['day']['condition']['text'];
        $city->weather_tomorrow = $response['forecast']['forecastday'][1]['day']['condition']['text'];
        $city->weather_updated_at = now();

        if ($saveToDB) {
            $city->save();
        }

        return $city;
    }
}
