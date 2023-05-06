<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Welcome\WelcomeController;
use Illuminate\Support\Facades\Route;

// Controllers for the API

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

Route::get('/', fn() => redirect('/v1'));

Route::prefix('v1')->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', [AuthController::class, 'getUser']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });
});
