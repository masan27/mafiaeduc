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
            \App\Services\Email\EmailServiceInterface::class,
            \App\Services\Email\EmailService::class
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
    }
}
