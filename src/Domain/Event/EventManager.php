<?php

declare(strict_types=1);

namespace Bank\Domain\Event;

use BRCas\CA\Contracts\Event\EventInterface;
use BRCas\CA\Contracts\Event\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    public function dispatch(array $event): void
    {
        dd('Implement dispatch() method.');
    }
}
