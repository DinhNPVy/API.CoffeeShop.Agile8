<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoffeeController;
use App\Http\Controllers\CoffeeBrandController;
use App\Http\Controllers\CoffeeTypeController;

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



Route::prefix('v1')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name("login");
    Route::post('/login-admin', [UserController::class, 'loginAdmin'])->name("login_admin");

    Route::middleware('auth:api')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::prefix('coffees')->group(function () {
                Route::controller(CoffeeController::class)->group(function () {
                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{id}', 'show');
                    Route::post('/{id}', 'update');
                    Route::delete('/{id}', 'destroy');
                    Route::put('/toggle-status/{id}', 'toggleStatus');
                });
            });

            Route::prefix('coffee-brands')->group(function () {
                Route::controller(CoffeeBrandController::class)->group(function () {
                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{id}', 'show');
                    Route::put('/{id}', 'update');       
                    Route::delete('/{id}', 'destroy');
                });
            });

            Route::prefix('coffee-types')->group(function () {
                Route::controller(CoffeeTypeController::class)->group(function () {
                    Route::get('/', 'index');
                    Route::post('/', 'store');
                    Route::get('/{id}', 'show');
                    Route::put('/{id}', 'update');       
                    Route::delete('/{id}', 'destroy');
                });
            });
        });
    });
});


