<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mentors\AdminMentorController;
use App\Http\Controllers\Mentors\MentorController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Payments\PaymentMethodController;
use App\Http\Controllers\Subjects\AdminSubjectController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Welcome\WelcomeController;
use Illuminate\Support\Facades\Route;


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

// Public Routes
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

    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::prefix('forgot-password')->group(function () {
        Route::post('send-email', [AuthController::class, 'sendResetLinkEmail']);
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'getUserNotification']);
            Route::post('mark-as-read', [NotificationController::class, 'markAsRead']);
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'getUserDetails']);
            Route::put('update', [UserController::class, 'updateUserDetails']);
            Route::post('change-password', [UserController::class, 'changePassword']);
        });

        Route::get('payment-methods', [PaymentMethodController::class, 'getPaymentMethods']);
        Route::post('mentor-register', [MentorController::class, 'mentorRegister']);
        Route::get('subjects', [SubjectController::class, 'getActiveSubjects']);
    });
});

// Admin Routes
Route::prefix('v1/admin')->group(function () {
    Route::prefix('mentors')->group(function () {
        Route::post('acceptance', [AdminMentorController::class, 'acceptMentorApplication']);

        Route::get('all', [AdminMentorController::class, 'getAllMentors']);
        Route::get('{mentorId}', [AdminMentorController::class, 'getMentorDetails']);
        Route::post('update-status', [AdminMentorController::class, 'nonActiveMentors']);
    });

    Route::prefix('subjects')->group(function () {
        Route::get('/', [AdminSubjectController::class, 'getAllSubjects']);
        Route::post('add', [AdminSubjectController::class, 'addSubject']);
        Route::put('{subjectId}', [AdminSubjectController::class, 'updateSubject']);
        Route::delete('{subjectId}', [AdminSubjectController::class, 'deleteSubject']);
    });
});

// Mentor Routes
Route::prefix('v1/mentor')->group(function () {
    Route::get('subjects', [SubjectController::class, 'getActiveSubjects']);
});
