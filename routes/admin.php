<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MobileAppController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PlanGroupController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CounteragentController;
use App\Http\Controllers\Admin\BasketController;
use App\Http\Controllers\Admin\StoreController;
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

Route::get('/',[AuthController::class,'login'])->name('login');
Route::post('auth',[AuthController::class,'auth'])->name('auth');



Route::middleware(['auth','admin'])->group(function () {
    Route::get('logout',[AuthController::class,'logout'])->name('logout');
    Route::get('main', [MainController::class, 'index'])->name('main');


    Route::prefix('product')->name('product.')->group(function (){
        Route::get('/',[ProductController::class,'index'])->name('index');
        Route::get('create',[ProductController::class,'create'])->name('create');
        Route::post('store',[ProductController::class,'store'])->name('store');
        Route::get('edit/{product}',[ProductController::class,'edit'])->name('edit');
        Route::get('show/{product}',[ProductController::class,'show'])->name('show');
        Route::put('update/{product}',[ProductController::class,'update'])->name('update');
        Route::get('delete/{product}',[ProductController::class,'delete'])->name('delete');
        Route::get('deleteImage/{productImage}',[ProductController::class,'deleteImage'])->name('deleteImage');
    });

    Route::prefix('user')->name('user.')->group(function (){
        Route::get('/',[UserController::class,'index'])->name('index');
        Route::get('create/{roleId}',[UserController::class,'create'])->name('create');
        Route::post('store',[UserController::class,'store'])->name('store');
        Route::get('edit/{user}',[UserController::class,'edit'])->name('edit');
        Route::get('show/{user}',[UserController::class,'show'])->name('show');
        Route::put('update/{user}',[UserController::class,'update'])->name('update');
        Route::get('delete/{user}',[UserController::class,'delete'])->name('delete');
    });
    Route::prefix('store')->name('store.')->group(function (){
        Route::get('/',[StoreController::class,'index'])->name('index');
        Route::get('create',[StoreController::class,'create'])->name('create');
        Route::post('store',[StoreController::class,'store'])->name('store');
        Route::get('edit/{store}',[StoreController::class,'edit'])->name('edit');
        Route::get('show/{store}',[StoreController::class,'show'])->name('show');
        Route::put('update/{store}',[StoreController::class,'update'])->name('update');
        Route::get('delete/{store}',[StoreController::class,'delete'])->name('delete');
        Route::get('move',[StoreController::class,'move'])->name('move');
        Route::post('moving',[StoreController::class,'moving'])->name('moving');
    });
    Route::prefix('counteragent')->name('counteragent.')->group(function (){
        Route::get('/',[CounteragentController::class,'index'])->name('index');
        Route::get('create',[CounteragentController::class,'create'])->name('create');
        Route::post('store',[CounteragentController::class,'store'])->name('store');
        Route::get('edit/{counteragent}',[CounteragentController::class,'edit'])->name('edit');
        Route::get('show/{counteragent}',[CounteragentController::class,'show'])->name('show');
        Route::put('update/{counteragent}',[CounteragentController::class,'update'])->name('update');
        Route::get('delete/{counteragent}',[CounteragentController::class,'delete'])->name('delete');
    });


    Route::prefix('brand')->name('brand.')->group(function (){
        Route::get('/',[BrandController::class,'index'])->name('index');
        Route::get('create',[BrandController::class,'create'])->name('create');
        Route::post('store',[BrandController::class,'store'])->name('store');
        Route::get('edit/{brand}',[BrandController::class,'edit'])->name('edit');
        Route::put('update/{brand}',[BrandController::class,'update'])->name('update');
        Route::get('delete/{brand}',[BrandController::class,'delete'])->name('delete');
    });
    Route::prefix('mobile-app')->name('mobile-app.')->group(function (){
        Route::get('/',[MobileAppController::class,'index'])->name('index');
        Route::get('create',[MobileAppController::class,'create'])->name('create');
        Route::post('store',[MobileAppController::class,'store'])->name('store');
        Route::get('delete/{mobileApp}',[MobileAppController::class,'delete'])->name('delete');
        Route::get('download/{mobileApp}',[MobileAppController::class,'download'])->name('download');
    });
    Route::prefix('category')->name('category.')->group(function (){
        Route::get('/{brand}',[CategoryController::class,'index'])->name('index');
        Route::get('create/{brand}',[CategoryController::class,'create'])->name('create');
        Route::post('store/{brand}',[CategoryController::class,'store'])->name('store');
        Route::get('edit/{category}',[CategoryController::class,'edit'])->name('edit');
        Route::put('update/{category}',[CategoryController::class,'update'])->name('update');
        Route::get('delete/{category}',[CategoryController::class,'delete'])->name('delete');
    });


    Route::prefix('role')->name('role.')->group(function (){
        Route::get('/',[RoleController::class,'index'])->name('index');
        Route::get('create/',[RoleController::class,'create'])->name('create');
        Route::post('store',[RoleController::class,'store'])->name('store');
        Route::get('edit/{role}',[RoleController::class,'edit'])->name('edit');
        Route::put('update/{role}',[RoleController::class,'update'])->name('update');
        Route::get('delete/{role}',[RoleController::class,'delete'])->name('delete');
    });

    Route::prefix('permission')->name('permission.')->group(function (){
        Route::get('/{role}',[PermissionController::class,'index'])->name('index');
        Route::get('create/{role}',[PermissionController::class,'create'])->name('create');
        Route::post('store/{role}',[PermissionController::class,'store'])->name('store');
        Route::get('edit/{permission}',[PermissionController::class,'edit'])->name('edit');
        Route::put('update/{permission}',[PermissionController::class,'update'])->name('update');
        Route::get('delete/{permission}',[PermissionController::class,'delete'])->name('delete');
    });

    Route::prefix('order')->name('order.')->group(function (){
        Route::get('/',[OrderController::class,'index'])->name('index');
        Route::get('create',[OrderController::class,'create'])->name('create');
        Route::post('store',[OrderController::class,'store'])->name('store');
        Route::get('edit/{order}',[OrderController::class,'edit'])->name('edit');
        Route::get('show/{order}',[OrderController::class,'show'])->name('show');
        Route::put('update/{order}',[OrderController::class,'update'])->name('update');
        Route::get('delete/{order}',[OrderController::class,'delete'])->name('delete');
    });
    Route::prefix('basket')->name('basket.')->group(function (){
        Route::get('create/{order}/{type}',[BasketController::class,'create'])->name('create');
        Route::post('store/{order}',[BasketController::class,'store'])->name('store');
        Route::get('edit/{basket}',[BasketController::class,'edit'])->name('edit');
        Route::put('update/{basket}',[BasketController::class,'update'])->name('update');
        Route::get('delete/{basket}',[BasketController::class,'delete'])->name('delete');
    });
    Route::prefix('plan-group')->name('plan-group.')->group(function (){
        Route::get('index/',[PlanGroupController::class,'index'])->name('index');
        Route::get('create/',[PlanGroupController::class,'create'])->name('create');
        Route::post('store/',[PlanGroupController::class,'store'])->name('store');
        Route::get('edit/{planGroup}',[PlanGroupController::class,'edit'])->name('edit');
        Route::put('update/{planGroup}',[PlanGroupController::class,'update'])->name('update');
        Route::get('delete/{planGroup}',[PlanGroupController::class,'delete'])->name('delete');
    });
});

