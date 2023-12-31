<?php

namespace App\Providers;

use App\Listeners\Transaction\CompletedListener;
use App\Listeners\Transaction\ConfirmedListener;
use App\Listeners\Transaction\CreateListener;
use CodePix\Bank\Domain\Events\Transaction\CompletedEvent;
use CodePix\Bank\Domain\Events\Transaction\ConfirmedEvent;
use CodePix\Bank\Domain\Events\Transaction\CreateEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreateEvent::class => [
            CreateListener::class,
        ],
        ConfirmedEvent::class => [
            ConfirmedListener::class,
        ],
        CompletedEvent::class => [
            CompletedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
