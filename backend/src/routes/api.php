<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::group(['middleware' => ['api']], function () {
    Route::prefix('v1')->group(function () {
        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::apiResource('product', ProductController::class)->only(['index', 'show']);
            Route::apiResource('cart', CartController::class);
            Route::get('cart-total', [CartController::class, 'total']);
            Route::get('cart-total-all', [CartController::class, 'totalAll']);
            Route::post('order/add', [OrderController::class, 'addOrder']);
            Route::get('order/list', [OrderController::class, 'getList']);
            Route::get('order/total', [OrderController::class, 'getTotal']);
            Route::delete('order/{order}/delete', [OrderController::class, 'deleteOrder']);
        });

        Route::post('create_token', [LoginController::class, 'login']);
        Route::get('auth-failed', [LoginController::class, 'failed'])->name('login');
    });
});
