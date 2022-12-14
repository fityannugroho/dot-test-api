<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::apiResource('provinces', 'App\Http\Controllers\ProvinceController')
    ->only(['index'])
    ->middleware('auth:sanctum');

Route::apiResource('cities', 'App\Http\Controllers\CityController')
    ->only(['index'])
    ->middleware('auth:sanctum');
