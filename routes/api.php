<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\MarketPurchasesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource(
    'orders',
    OrdersController::class
)->only(
    [
        'index',
        'store',
    ]
);
Route::apiResource(
    'stock',
    StockController::class
)->only(
    [
        'index',
    ]
);
Route::apiResource(
    'recipes',
    RecipesController::class
)->only(
    [
        'index',
    ]
);
Route::apiResource(
    'market-purchases',
    MarketPurchasesController::class
)->only(
    [
        'index',
    ]
);
