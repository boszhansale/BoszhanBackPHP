<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Driver\BasketController as DriverBasketController;
use App\Http\Controllers\Api\Driver\OrderController as DriverOrderController;
use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Salesrep\CounteragentController;
use App\Http\Controllers\Api\Salesrep\GameController;
use App\Http\Controllers\Api\Salesrep\OrderController;
use App\Http\Controllers\Api\Salesrep\PlanController;
use App\Http\Controllers\Api\Salesrep\StoreController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('brand', [ListController::class, 'brand']);
Route::get('status', [ListController::class, 'status']);
Route::get('payment-type', [ListController::class, 'paymentType']);
Route::get('payment-status', [ListController::class, 'paymentStatus']);
Route::get('reason-refund', [ListController::class, 'reasonRefund']);
Route::get('position', [ListController::class, 'position']);

Route::get('mobile-app', [ListController::class, 'mobileApp']);
Route::get('mobile-app/download', [ListController::class, 'mobileAppDownload']);

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{order}', [ProductController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('position', [AuthController::class, 'position']);
    Route::post('device-token', [AuthController::class, 'deviceToken']);

    //Salesrep

    Route::get('counteragent', [ListController::class, 'counteragent']); //delete method

    Route::get('plan', [OrderController::class, 'plan']); //delete method

    Route::prefix('store')->group(function () {
        Route::get('/', [StoreController::class, 'index']);
        Route::post('/', [StoreController::class, 'store']);
        Route::post('/{store}', [StoreController::class, 'update']);
        Route::delete('/{store}', [StoreController::class, 'delete']);
    });
    Route::get('order-info', [OrderController::class, 'info']);

    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store']);
        Route::get('/{order}', [OrderController::class, 'show']);
        Route::post('/{order}', [OrderController::class, 'update']);
        Route::delete('/{order}', [OrderController::class, 'delete']);
    });

    Route::prefix('salesrep')->group(function () {
        Route::get('plan', [PlanController::class, 'index']);
        Route::get('counteragent', [CounteragentController::class, 'index']);

        Route::prefix('store')->group(function () {
            Route::get('/', [StoreController::class, 'index']);
            Route::get('last-orders', [StoreController::class, 'lastOrders']);
            Route::post('/', [StoreController::class, 'store']);
            Route::post('update/{store}', [StoreController::class, 'update']);
            Route::delete('{store}', [StoreController::class, 'delete']);
        });

        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::post('/', [OrderController::class, 'store']);

            Route::get('show/{order}', [OrderController::class, 'show']);
            Route::post('update/{order}', [OrderController::class, 'update']);
            Route::delete('/{order}', [OrderController::class, 'delete']);

            Route::get('info', [OrderController::class, 'info']);
        });

        Route::prefix('game')->group(function () {
            Route::get('/', [GameController::class, 'index']);
            Route::post('/', [GameController::class, 'store']);
        });
    });

    //Salesrep end

    //Driver

    Route::prefix('driver')->group(function () {
        Route::prefix('order')->group(function () {
            Route::get('/', [DriverOrderController::class, 'index']);
            Route::get('delivered', [DriverOrderController::class, 'delivered']);
            Route::get('show/{order}', [DriverOrderController::class, 'show']);
            Route::post('update/{order}', [DriverOrderController::class, 'update']);
            Route::get('info', [DriverOrderController::class, 'info']);
        });

        Route::prefix('basket')->group(function () {
            Route::get('{order}', [DriverBasketController::class, 'index']);
            Route::post('update/{basket}', [DriverBasketController::class, 'update']);
            Route::post('initial-state/{order}', [DriverBasketController::class, 'initialState']);
            Route::delete('{basket}', [DriverBasketController::class, 'delete']);
        });

        Route::withoutMiddleware('auth:sanctum')->prefix('print')->group(function () {
            Route::get('{order}/rnk', [DriverOrderController::class, 'rnk']);
            Route::get('{order}/before/rnk', [DriverOrderController::class, 'beforeRnk']);
            Route::get('{order}/vozvrat', [DriverOrderController::class, 'vozvrat']);
            Route::get('{order}/pko', [DriverOrderController::class, 'pko']);
        });
    });
});
