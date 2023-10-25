<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use CodePix\Bank\Domain\Events\Transaction\CompletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompletedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected AMQPInterface $AMQP)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CompletedEvent $event): void
    {
        $this->AMQP->publish('transaction.complete', [
            'id' => $event->payload()['id'],
        ]);
    }
}
