<?php

namespace App\Listeners\Transaction;

use App\Services\Interfaces\AMQPInterface;
use CodePix\Bank\Domain\Events\Transaction\CreateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateListener
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
    public function handle(CreateEvent $event): void
    {
        $this->AMQP->publish('transaction.creating', $event->payload());
    }
}
