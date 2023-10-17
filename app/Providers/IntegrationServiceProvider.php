<?php

namespace App\Providers;

use Bank\Integration\PixKeyIntegration;
use CodePix\Bank\Application\integration\PixKeyIntegrationInterface;
use Illuminate\Support\ServiceProvider;

class IntegrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PixKeyIntegrationInterface::class, PixKeyIntegration::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
