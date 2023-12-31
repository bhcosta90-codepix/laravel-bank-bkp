<?php

namespace App\Providers;

use App\Services\Interfaces\AMQPInterface;
use App\Services\Interfaces\RabbitMQInterface;
use App\Services\RabbitMQService;
use Bank\Domain\Event\EventManager;
use Bank\TransactionInterface\DatabaseTransaction;
use BRCas\CA\Contracts\Event\EventManagerInterface;
use BRCas\CA\Contracts\Transaction\DatabaseTransactionInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton(EventManagerInterface::class, EventManager::class);
        $this->app->singleton(DatabaseTransactionInterface::class, DatabaseTransaction::class);

        $this->app->singleton(AMQPInterface::class, RabbitMQInterface::class);
        $this->app->singleton(RabbitMQInterface::class, RabbitMQService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
