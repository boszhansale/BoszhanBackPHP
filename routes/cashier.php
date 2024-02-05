<?php


use App\Http\Controllers\Admin\LabelProductController;
use App\Http\Controllers\Cashier\MainController;
use App\Http\Controllers\Cashier\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('show/{counteragent}', [MainController::class, 'show'])->name('show');
Route::post('add-balance', [MainController::class, 'addBalance'])->name('add-balance');
Route::prefix('order')->name('order.')->group(function () {
    Route::get('counteragent/{counteragent}', [MainController::class, 'counteragent'])->name('counteragent');
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('to-onec', [OrderController::class, 'toOnec'])->name('to-onec');
    Route::get('show/{order}', [OrderController::class, 'show'])->name('show');
    Route::get('export-excel/{order}', [OrderController::class, 'exportExcel'])->name('export-excel');
    Route::get('waybill/{order}', [OrderController::class, 'waybill'])->name('waybill');
    Route::get('statistic', [OrderController::class, 'statistic'])->name('statistic');
    Route::get('history/{order}', [OrderController::class, 'history'])->name('history');
});


Route::prefix('label-product')->name('label-product.')->group(function () {
    Route::get('/', [LabelProductController::class, 'index'])->name('index');
    Route::get('create', [LabelProductController::class, 'create'])->name('create');
    Route::post('store', [LabelProductController::class, 'store'])->name('store');
    Route::get('edit/{labelProduct}', [LabelProductController::class, 'edit'])->name('edit');
    Route::put('update/{labelProduct}', [LabelProductController::class, 'update'])->name('update');
    Route::get('delete/{labelProduct}', [LabelProductController::class, 'delete'])->name('delete');
});



