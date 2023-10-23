<?php

namespace App\Providers;

use Bank\Domain\Repository\PixKeyRepository;
use Bank\Domain\Repository\TransactionRepository;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;
use CodePix\Bank\Domain\Repository\TransactionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PixKeyRepositoryInterface::class, PixKeyRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
