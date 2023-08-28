<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\MentorAuthController;
use App\Http\Controllers\Checkouts\CheckoutController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\GroupClasses\AdminGroupClassController;
use App\Http\Controllers\GroupClasses\GroupClassController;
use App\Http\Controllers\Materials\AdminMaterialController;
use App\Http\Controllers\Materials\MaterialController;
use App\Http\Controllers\Mentors\AdminMentorController;
use App\Http\Controllers\Mentors\MentorController;
use App\Http\Controllers\Mentors\MentorPaymentMethodController;
use App\Http\Controllers\Mentors\MentorPrivateClassController;
use App\Http\Controllers\Mentors\MentorScheduleController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Payments\AdminPaymentMethodController;
use App\Http\Controllers\Payments\PaymentMethodController;
use App\Http\Controllers\PrivateClasses\PrivateClassController;
use App\Http\Controllers\Reviews\ReviewController;
use App\Http\Controllers\Schedules\AdminScheduleController;
use App\Http\Controllers\Schedules\ScheduleController;
use App\Http\Controllers\Subjects\AdminSubjectController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Transactions\AdminTransactionController;
use App\Http\Controllers\Users\AdminUserController;
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

            Route::get('materials', [MaterialController::class, 'getUserMaterial']);
            Route::get('schedules', [ScheduleController::class, 'getUserSchedules']);
        });

        Route::get('payment-methods', [PaymentMethodController::class, 'getPaymentMethods']);
        Route::post('mentor-register', [MentorController::class, 'mentorRegister']);
        Route::get('grades', [GradeController::class, 'getGrades']);
        Route::get('subjects', [SubjectController::class, 'getActiveSubjects']);

        Route::post('checkout', [CheckoutController::class, 'makeCheckout']);
        Route::get('invoice/{salesId}', [CheckoutController::class, 'getInvoiceDetails']);
        Route::post('payment-confirmation', [CheckoutController::class, 'paymentConfirmation']);
        Route::post('cancel-payment', [CheckoutController::class, 'cancelPayment']);
    });

    Route::prefix('materials')->group(function () {
        Route::get('/', [MaterialController::class, 'getActiveMaterial']);
        Route::get('{materialId}', [MaterialController::class, 'getMaterialDetails']);
        Route::get('download/{materialId}/preview', [AdminMaterialController::class, 'downloadMaterialPreview']);
        Route::get('download/{materialId}/source', [AdminMaterialController::class, 'downloadMaterialSource']);
    });

    Route::get('group-classes', [GroupClassController::class, 'getAllGroupClasses']);
    Route::get('group-classes/{groupClassId}', [GroupClassController::class, 'getGroupClassDetails']);

    Route::get('private-classes', [PrivateClassController::class, 'getAllPrivateClasses']);
    Route::get('private-classes/{privateClassId}', [PrivateClassController::class, 'getPrivateClassDetails']);

    Route::post('reviews', [ReviewController::class, 'addTransactionReview']);

    Route::get('recommended-mentors', [MentorController::class, 'getRecommendedMentors']);
    Route::get('mentors/{mentorId}/classes', [MentorController::class, 'getAllMentorClass']);
});

// Admin Routes
Route::prefix('v1/admin')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AdminAuthController::class, 'login']);
        Route::post('register', [AdminAuthController::class, 'register']);

        Route::middleware('auth:sanctum,admin')->group(function () {
            Route::get('profile', [AdminAuthController::class, 'getProfileDetails']);
            Route::post('logout', [AdminAuthController::class, 'logout']);
        });
    });

    Route::post('reset-password', [AdminAuthController::class, 'resetPassword']);
    Route::prefix('forgot-password')->group(function () {
        Route::post('send-email', [AdminAuthController::class, 'sendResetLinkEmail']);
    });

    Route::prefix('mentors')->group(function () {
        Route::post('acceptance', [AdminMentorController::class, 'acceptMentorApplication']);

        Route::get('/', [AdminMentorController::class, 'getAllMentors']);
        Route::get('/request', [AdminMentorController::class, 'getAllMentorRequest']);
        Route::get('/request/{mentorId}', [AdminMentorController::class, 'getMentorRequestDetails']);
        Route::get('{mentorId}', [AdminMentorController::class, 'getMentorDetails']);
        Route::post('update-status', [AdminMentorController::class, 'nonActiveMentors']);
        Route::post('reset-password', [AdminMentorController::class, 'resetPassword']);
    });

    Route::prefix('subjects')->group(function () {
        Route::get('/', [AdminSubjectController::class, 'getAllSubjects']);
        Route::post('add', [AdminSubjectController::class, 'addSubject']);
        Route::put('{subjectId}', [AdminSubjectController::class, 'updateSubject']);
        Route::delete('{subjectId}', [AdminSubjectController::class, 'deleteSubject']);
    });

    Route::get('grades', [GradeController::class, 'getGrades']);

    Route::prefix('payment-methods')->group(function () {
        Route::get('/', [AdminPaymentMethodController::class, 'getAdminPaymentMethods']);
        Route::post('/', [AdminPaymentMethodController::class, 'addPaymentMethod']);
        Route::put('/{paymentMethodId}', [AdminPaymentMethodController::class, 'editPaymentMethod']);
        Route::post('non-active', [AdminPaymentMethodController::class, 'nonActivePaymentMethod']);
        Route::delete('/{paymentMethodId}', [AdminPaymentMethodController::class, 'deletePaymentMethod']);
    });

    Route::middleware('auth:sanctum,admin')->group(function () {
        Route::prefix('material')->group(function () {
            Route::get('/', [AdminMaterialController::class, 'getAllMaterial']);
            Route::post('add', [AdminMaterialController::class, 'addMaterial']);
            Route::delete('{materialId}', [AdminMaterialController::class, 'deleteMaterial']);
            Route::post('update/{materialId}', [AdminMaterialController::class, 'updateMaterial']);
        });
    });

    Route::prefix('material')->group(function () {
        Route::get('download/{materialId}/preview', [AdminMaterialController::class, 'downloadMaterialPreview']);
        Route::get('download/{materialId}/source', [AdminMaterialController::class, 'downloadMaterialSource']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'getAllUsers']);
        Route::get('{userId}', [AdminUserController::class, 'getUserDetails']);
        Route::post('reset-password/{userId}', [AdminUserController::class, 'resetPassword']);
        Route::post('update-status/{userId}', [AdminUserController::class, 'nonActiveUsers']);
    });

    Route::prefix('group-classes')->group(function () {
        Route::get('/', [AdminGroupClassController::class, 'getAllGroupClasses']);
        Route::get('{groupClassId}', [AdminGroupClassController::class, 'getGroupClassDetails']);
        Route::post('add', [AdminGroupClassController::class, 'addGroupClass']);
        Route::patch('{groupClassId}', [AdminGroupClassController::class, 'updateGroupClass']);
        Route::delete('{groupClassId}', [AdminGroupClassController::class, 'deleteGroupClass']);
        Route::post('update-status/{groupClassId}', [AdminGroupClassController::class, 'updateStatusGroupClass']);
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'getAllTransactions']);
        Route::get('{salesId}', [AdminTransactionController::class, 'getTransactionDetails']);
        Route::post('confirm', [AdminTransactionController::class, 'confirmTransaction']);
    });

    Route::prefix('schedules')->group(function () {
        Route::get('{groupClassId}', [AdminScheduleController::class, 'getSchedules']);
        Route::post('{groupClassId}/add', [AdminScheduleController::class, 'addSchedule']);
        Route::patch('{scheduleId}', [AdminScheduleController::class, 'editSchedule']);
        Route::delete('{scheduleId}', [AdminScheduleController::class, 'deleteSchedule']);
    });

    Route::post('assign-user-material', [AdminMaterialController::class, 'assignUserMaterial']);

    // TODO: make mentor payment (get, add, update)
});

// Mentor Routes
Route::prefix('v1/mentor')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [MentorAuthController::class, 'login']);

        Route::middleware('checkMentorToken')->group(function () {
            Route::get('profile', [MentorAuthController::class, 'getProfileDetails']);
            Route::post('logout', [MentorAuthController::class, 'logout']);
        });
    });

    Route::post('reset-password', [MentorAuthController::class, 'resetPassword']);
    Route::prefix('forgot-password')->group(function () {
        Route::post('send-email', [MentorAuthController::class, 'sendResetLinkEmail']);
    });

    Route::get('subjects', [SubjectController::class, 'getActiveSubjects']);
    Route::get('grades', [GradeController::class, 'getGrades']);
    Route::get('payment-methods', [PaymentMethodController::class, 'getPaymentMethods']);

    Route::middleware('checkMentorToken')->group(function () {
        Route::put('profile/update', [MentorController::class, 'updateProfile']);
        Route::post('profile/change-password', [MentorController::class, 'changePassword']);
        Route::post('profile/change-photo', [MentorController::class, 'changePhoto']);

        Route::get('stats', [MentorController::class, 'getMentorStats']);

        Route::get('mentor-payment-methods', [MentorPaymentMethodController::class, 'getMentorPaymentMethods']);
        Route::post('mentor-payment-methods', [MentorPaymentMethodController::class, 'addMentorPaymentMethod']);
        Route::delete('mentor-payment-methods/{mentorPaymentMethodId}', [MentorPaymentMethodController::class, 'deleteMentorPaymentMethod']);

        Route::prefix('private-classes')->group(function () {
            Route::get('/', [MentorPrivateClassController::class, 'getMentorPrivateClasses']);
            Route::get('orders', [MentorPrivateClassController::class, 'getMentorPrivateClassOrders']);
            Route::get('{privateClassId}', [MentorPrivateClassController::class, 'getMentorPrivateClassDetails']);
            Route::post('add', [MentorPrivateClassController::class, 'addMentorPrivateClass']);
            Route::patch('{privateClassId}', [MentorPrivateClassController::class, 'editMentorPrivateClass']);
            Route::post('{privateClassId}/change-status', [MentorPrivateClassController::class, 'changeMentorPrivateClassStatus']);
            Route::delete('{privateClassId}', [MentorPrivateClassController::class, 'deleteMentorPrivateClass']);
        });

        Route::prefix('schedules')->group(function () {
            Route::get('recent', [MentorScheduleController::class, 'getRecentSchedules']);
            Route::get('{privateClassId}', [MentorScheduleController::class, 'getMentorSchedules']);
            Route::post('{privateClassId}/add', [MentorScheduleController::class, 'addMentorSchedule']);
            Route::post('done/{scheduleId}', [MentorScheduleController::class, 'doneMentorSchedule']);
            Route::patch('{scheduleId}', [MentorScheduleController::class, 'editMentorSchedule']);
            Route::delete('{scheduleId}', [MentorScheduleController::class, 'deleteMentorSchedule']);
        });
    });
});
