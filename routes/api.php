<?php

use App\Http\Controllers\API\ArtCategoryController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomePageController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\NftProductController;
use App\Http\Controllers\API\PurchasingProductController;
use App\Http\Controllers\API\UserAccountController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('w3login', 'w3Login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::get('refresh', 'refresh');
//    Route::get('getProfile', 'userProfile');
});
Route::prefix('home')->controller(HomePageController::class)->group(function () {
    Route::get('get-slides', 'getSlide');
});
Route::prefix('page-account')->controller(UserAccountController::class)->group(function () {
//    Route::get('get-profile', 'getProfile');

    Route::get('referrals', 'getChildren');
    Route::post('add-exchange', 'addExchange');
    Route::get('get-exchanges', 'getExchange');
    Route::get('get-withdraws', 'getWithdraw');
    Route::post('add-withdraw', 'addWithdraw');
});

Route::prefix('art-category')->controller(ArtCategoryController::class)->group(function () {
    Route::get('arts', 'getArt');
//    Route::post('arts', 'getArtByLevel');
});
Route::prefix('nft-product')->controller(NftProductController::class)->group(function () {
    Route::post('getProducts', 'getNftProduct');
    Route::post('postNft', 'postNftProduct');
});
Route::prefix('nft-product')->controller(LikeController::class)->group(function () {
    Route::get('get-likes', 'getLike');
    Route::post('toggle-like', 'storeLike');
});
Route::prefix('sell-purchase')->controller(PurchasingProductController::class)->group(function () {
    Route::get('get-purchases', 'get');
    Route::post('purchase-nft', 'purchaseProduct');
});
