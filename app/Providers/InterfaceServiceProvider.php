<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register the Service Interfaces
        // -------------------------------

        $this->app->bind(
            \App\Services\Welcome\WelcomeServiceInterface::class,
            \App\Services\Welcome\WelcomeService::class
        );

        $this->app->bind(
            \App\Services\Auth\AuthServiceInterface::class,
            \App\Services\Auth\AuthService::class
        );

        $this->app->bind(
            \App\Services\ForgotPassword\ForgotPasswordServiceInterface::class,
            \App\Services\ForgotPassword\ForgotPasswordService::class
        );

        $this->app->bind(
            \App\Services\Notifications\NotificationServiceInterface::class,
            \App\Services\Notifications\NotificationService::class
        );

        $this->app->bind(
            \App\Services\Users\UserServiceInterface::class,
            \App\Services\Users\UserService::class
        );

        $this->app->bind(
            \App\Services\Payments\PaymentMethodServiceInterface::class,
            \App\Services\Payments\PaymentMethodService::class
        );

        $this->app->bind(
            \App\Services\Mentors\MentorServiceInterface::class,
            \App\Services\Mentors\MentorService::class
        );

        $this->app->bind(
            \App\Services\Subjects\SubjectServiceInterface::class,
            \App\Services\Subjects\SubjectService::class
        );

        $this->app->bind(
            \App\Services\Admins\Auth\AdminAuthServiceInterface::class,
            \App\Services\Admins\Auth\AdminAuthService::class
        );

        $this->app->bind(
            \App\Services\Mentors\Auth\MentorAuthServiceInterface::class,
            \App\Services\Mentors\Auth\MentorAuthService::class
        );

        $this->app->bind(
            \App\Services\Mentors\PaymentMethod\MentorPaymentMethodServiceInterface::class,
            \App\Services\Mentors\PaymentMethod\MentorPaymentMethodService::class
        );

        $this->app->bind(
            \App\Services\Admins\Materials\AdminMaterialServiceInterface::class,
            \App\Services\Admins\Materials\AdminMaterialService::class
        );

        $this->app->bind(
            \App\Services\Admins\Users\AdminUserServiceInterface::class,
            \App\Services\Admins\Users\AdminUserService::class
        );

        $this->app->bind(
            \App\Services\Mentors\PrivateClasses\MentorPrivateClassServiceInterface::class,
            \App\Services\Mentors\PrivateClasses\MentorPrivateClassService::class
        );

        $this->app->bind(
            \App\Services\Admins\GroupClasses\AdminGroupClassesInterface::class,
            \App\Services\Admins\GroupClasses\AdminGroupClassesService::class
        );

        $this->app->bind(
            \App\Services\Mentors\Schedules\MentorScheduleServiceInterface::class,
            \App\Services\Mentors\Schedules\MentorScheduleService::class
        );

        $this->app->bind(
            \App\Services\Checkouts\CheckoutServiceInterface::class,
            \App\Services\Checkouts\CheckoutService::class
        );

        $this->app->bind(
            \App\Services\Admins\Transactions\AdminTransactionServiceInterface::class,
            \App\Services\Admins\Transactions\AdminTransactionService::class
        );

        $this->app->bind(
            \App\Services\Admins\Schedules\AdminScheduleServiceInterface::class,
            \App\Services\Admins\Schedules\AdminScheduleService::class
        );

        $this->app->bind(
            \App\Services\GroupClasses\GroupClassServiceInterface::class,
            \App\Services\GroupClasses\GroupClassService::class
        );

        $this->app->bind(
            \App\Services\PrivateClasses\PrivateClassServiceInterface::class,
            \App\Services\PrivateClasses\PrivateClassService::class,
        );

        $this->app->bind(
            \App\Services\Materials\MaterialServiceInterface::class,
            \App\Services\Materials\MaterialService::class,
        );

        $this->app->bind(
            \App\Services\Schedules\ScheduleServiceInterface::class,
            \App\Services\Schedules\ScheduleService::class,
        );

        $this->app->bind(
            \App\Services\Grades\GradeServiceInterface::class,
            \App\Services\Grades\GradeService::class,
        );

        // Register the Repository Interfaces
        // -------------------------------

        $this->app->bind(
            \App\Repository\Auth\AuthRepoInterface::class,
            \App\Repository\Auth\AuthRepo::class
        );

        $this->app->bind(
            \App\Repository\Users\UserRepoInterface::class,
            \App\Repository\Users\UserRepo::class
        );

        $this->app->bind(
            \App\Repository\Notifications\NotificationRepoInterface::class,
            \App\Repository\Notifications\NotificationRepo::class
        );

        $this->app->bind(
            \App\Repository\AccessLogs\AccessLogRepoInterface::class,
            \App\Repository\AccessLogs\AccessLogRepo::class
        );

        $this->app->bind(
            \App\Repository\Payments\PaymentMethodRepoInterface::class,
            \App\Repository\Payments\PaymentMethodRepo::class
        );

        $this->app->bind(
            \App\Repository\Mentors\MentorRepoInterface::class,
            \App\Repository\Mentors\MentorRepo::class
        );

        $this->app->bind(
            \App\Repository\Subjects\SubjectRepoInterface::class,
            \App\Repository\Subjects\SubjectRepo::class
        );

        $this->app->bind(
            \App\Repository\Admin\AdminRepoInterface::class,
            \App\Repository\Admin\AdminRepo::class,
        );

        $this->app->bind(
            \App\Repository\PasswordResetToken\PasswordResetTokenRepoInterface::class,
            \App\Repository\PasswordResetToken\PasswordResetTokenRepo::class,
        );

        $this->app->bind(
            \App\Repository\MentorPaymentMethod\MentorPaymentMethodRepoInterface::class,
            \App\Repository\MentorPaymentMethod\MentorPaymentMethodRepo::class
        );
    }
}
