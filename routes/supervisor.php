<?php


use App\Http\Controllers\Supervisor\MainController;
use App\Http\Controllers\Supervisor\OrderController;
use App\Http\Controllers\Supervisor\StoreController;
use App\Http\Controllers\Supervisor\UserController;


Route::get('/', [MainController::class, 'index'])->name('main');


Route::prefix('user')->name('user.')->group(function () {
    Route::get('drivers', [UserController::class, 'drivers'])->name('drivers');
    Route::get('salesreps', [UserController::class, 'salesreps'])->name('salesreps');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('show/{user}', [UserController::class, 'show'])->name('show');
    Route::get('position/{user}', [UserController::class, 'position'])->name('position');
    Route::get('order/{user}/{role}', [UserController::class, 'order'])->name('order');
});
Route::prefix('store')->name('store.')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('index');
    Route::get('create', [StoreController::class, 'create'])->name('create');
    Route::post('store', [StoreController::class, 'store'])->name('store');
    Route::get('edit/{store}', [StoreController::class, 'edit'])->name('edit');
    Route::get('show/{store}', [StoreController::class, 'show'])->name('show');
    Route::put('update/{store}', [StoreController::class, 'update'])->name('update');
    Route::get('remove/{store}', [StoreController::class, 'remove'])->name('remove');
    Route::get('order/{store}', [StoreController::class, 'order'])->name('order');
    Route::get('move', [StoreController::class, 'move'])->name('move');
    Route::post('moving', [StoreController::class, 'moving'])->name('moving');
});


Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('to-onec', [OrderController::class, 'toOnec'])->name('to-onec');
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::post('store', [OrderController::class, 'store'])->name('store');
    Route::get('edit/{order}', [OrderController::class, 'edit'])->name('edit');
    Route::get('show/{order}', [OrderController::class, 'show'])->name('show');
    Route::put('update/{order}', [OrderController::class, 'update'])->name('update');
    Route::get('remove/{order}', [OrderController::class, 'remove'])->name('remove');
    Route::get('recover/{order}', [OrderController::class, 'recover'])->name('recover');
    Route::get('export-excel/{order}', [OrderController::class, 'exportExcel'])->name('export-excel');
    Route::get('waybill/{order}', [OrderController::class, 'waybill'])->name('waybill');
    Route::get('driver-move', [OrderController::class, 'driverMove'])->name('driver-move');
    Route::post('driver-moving', [OrderController::class, 'driverMoving'])->name('driver-moving');
    Route::get('statistic', [OrderController::class, 'statistic'])->name('statistic');
    Route::get('history/{order}', [OrderController::class, 'history'])->name('history');
});
