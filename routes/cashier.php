<?php


use App\Http\Controllers\Cashier\MainController;


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
Route::get('order/{counteragent}', [MainController::class, 'order'])->name('order');
