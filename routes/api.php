<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'product'], function() {
    Route::post('/store', [ProductsController::class, 'store']);
    Route::get('/fetch', [ProductsController::class, 'fetch']);
    Route::delete('/{id}', [ProductsController::class, 'delete']);
    Route::patch('/{id}', [ProductsController::class, 'patch']);
    Route::put('/{id}', [ProductsController::class, 'update']);
});