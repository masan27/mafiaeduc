<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers for the API
use App\Http\Controllers\WelcomeController;

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

});
