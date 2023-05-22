<?php

namespace App\Http\Controllers\Api\v3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class WatherapiController extends Controller
{
    public static function getWeatherAllCities(Request $request)
    {
        $cities = City::all();

        return response()->json([
            'status' => 'success',
            'messages' => [
                $cities->__toString(),
            ]
        ], 200);
    }

    public static function getWeatherByCityId(Request $request, Int $cityId)
    {
        $city = City::find($cityId);

        if (empty($city)) {
            return response()->json([
                'status' => 'error',
                'message' => "The city with id={$cityId} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => $city->__toString(),
        ], 200);
    }

    public static function getWeatherForApiByCityName(Request $request, string $cityName)
    {
        $result = City::getWeatherByApi($cityName, $request->get('save', false));

        if (! $result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Make sure you send the correct name for the city',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => $result->__toString(),
        ], 200);
    }
}
