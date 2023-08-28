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
    Route::get('get-slides', 'getSlide');
    Route::get('get-quest-corridors', 'getQuestCorridor');
    Route::get('get-analogData', 'getAnalogData');
    Route::get('get-cooperated-films', 'getCooperatedFilm');
});
Route::prefix('detail-page')->controller(\App\Http\Controllers\API\DetailPageController::class)->group(function () {
    Route::get('get-new-arrival', 'getNewArrival');
    Route::get('get-casts', 'getCast');
    Route::get('get-blockbuster-histories', 'getBlockbusterHistory');
    Route::get('get-investments', 'getInvestment');
});
Route::prefix('personal-account')->controller(\App\Http\Controllers\API\UserAccountController::class)->group(function () {
    Route::get('get-deposits', 'getDeposit');
    Route::post('add-deposit', 'storeDeposit');
    Route::get('get-withdraws', 'getWithdraw');
    Route::post('add-withdraw', 'storeWithdraw');
    Route::get('get-bank-cards', 'getBankCardManagement');
    Route::post('add-bank-card', 'storeBankCardManagement');
    Route::post('change-password', 'changePassword');
    Route::post('set-withdraw-password', 'withdrawPassword');
    Route::get('referrals', 'getChildren');
});
