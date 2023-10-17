<?php

namespace App\Providers;

use Bank\Domain\Repository\PixKeyRepository;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PixKeyRepositoryInterface::class, PixKeyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
