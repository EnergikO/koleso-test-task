<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v3;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("/cities", [v3\WatherapiController::class, "getWeatherByCityId"]);
Route::get("/cities/{city_id}", [v3\WatherapiController::class, "getWeatherAllCities"]);
