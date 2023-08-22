<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(\App\Http\Controllers\API\AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::get('refresh', 'refresh');
//    Route::get('getProfile', 'userProfile');
});
Route::prefix('home')->controller(\App\Http\Controllers\API\HomePageController::class)->group(function () {
    Route::get('getSlides', 'getSlide');
    Route::get('getQuestCorridors', 'getQuestCorridor');
    Route::get('getAnalogData', 'getAnalogData');
    Route::get('getCooperatedFilms', 'getCooperatedFilm');
});
Route::prefix('detail-page')->controller(\App\Http\Controllers\API\DetailPageController::class)->group(function () {
    Route::get('getNewArrival', 'getNewArrival');
    Route::get('getCasts', 'getCast');
    Route::get('getBlockbusterHistories', 'getBlockbusterHistory');
    Route::get('getInvestments', 'getInvestment');
});
