<?php

use App\Http\Controllers\Welcome\WelcomeController;
use Illuminate\Support\Facades\Route;

// Controllers for the API

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WelcomeController::class, 'welcome']);
