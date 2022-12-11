<?php

use Illuminate\Http\Request;
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

Route::group(
    [
        'prefix' => 'auth',
        'middleware' => 'guest:sanctum',
    ],
    function() {
        Route::post(
            '/register', 
            [UserController::class, 'register'],
        );
        Route::post(
            '/login', 
            [UserController::class, 'login'],
        );
    }
);

Route::group(
    [
        'prefix' => 'product', 
        'middleware' => 'auth:sanctum',
    ],
    function() {
        Route::post(
            '/store', 
            [ProductsController::class, 'store'],
        );
        Route::get(
            '/fetch', 
            [ProductsController::class, 'fetch'],
        );
        Route::delete(
            '/{id}', 
            [ProductsController::class, 'delete'],
        );
        Route::patch(
            '/{id}', 
            [ProductsController::class, 'patch'],
        );
        Route::put(
            '/{id}', 
            [ProductsController::class, 'update'],
        );
    }
);

Route::group(
    [
        'prefix' => 'orders',
        'middleware' => 'auth:sanctum',
    ],
    function() {
        Route::post(
            '/store', 
            [OrdersController::class, 'store'],
        );
        Route::get(
            '/fetch', 
            [OrdersController::class, 'fetch'],
        );
    }
);
