<?php

declare(strict_types=1);

namespace App\Services;

interface AMQPInterface
{
    public function publish($name, array $value = []): void;
}
