<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return redirect('https://boszhan.com');
});
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'auth'])->name('auth');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('test', function () {
    return view('exports.excel.driver_store_distance');
});

Route::get('label', [LabelController::class, 'create'])->name('label.create');
Route::post('label', [LabelController::class, 'store'])->name('label.store');
Route::get('label/{label}', [LabelController::class, 'show'])->name('label.show');
