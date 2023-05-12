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
    }
}
