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

        // Register the Repository Interfaces
        // -------------------------------
    }
}
