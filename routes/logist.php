<?php


use App\Http\Controllers\Cashier\MainController;
use App\Http\Controllers\Logist\UserController;


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

Route::prefix('user')->name('user.')->group(function () {
    Route::get('drivers', [UserController::class, 'drivers'])->name('drivers');
    Route::get('riders', [UserController::class, 'riders'])->name('riders');
    Route::get('riders-excel', [UserController::class, 'riderExcel'])->name('riderExcel');
    Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::get('show/{user}', [UserController::class, 'show'])->name('show');
    Route::put('update/{user}', [UserController::class, 'update'])->name('update');
    Route::get('order/{user}/{role}', [UserController::class, 'order'])->name('order');
    Route::post('statistic/by-order-excel', [UserController::class, 'statisticByOrderExcel'])->name('statisticByOrderExcel');
});
