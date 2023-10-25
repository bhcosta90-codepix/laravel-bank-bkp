<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use CodePix\Bank\Domain\Events\Transaction\ConfirmedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ConfirmedListener
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
    public function handle(ConfirmedEvent $event): void
    {
        $this->AMQP->publish('transaction.confirmation', [
            'id' => $event->payload()['id'],
        ]);
    }
}
