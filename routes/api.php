<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;

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

Route::controller(UserController::class)->middleware('guest:sanctum')->prefix('auth')->group(
    function() {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    }
);

Route::controller(ProductsController::class)->middleware('auth:sanctum')->prefix('product')->group(
    function() {
        Route::post('/store', 'store');
        Route::get('/fetch','fetch');
        Route::delete('/{id}', 'delete');
        Route::patch('/{id}', 'patch');
        Route::put('/{id}', 'update');
    }
);

Route::controller(OrdersController::class)->middleware('auth:sanctum')->prefix('orders')->group(
    function() {
        Route::post('/store', 'store');
        Route::get('/fetch', 'fetch');
    }
);
