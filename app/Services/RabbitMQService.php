<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\AMQPInterface;
use App\Services\Interfaces\RabbitMQInterface;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Log;
use Throwable;

class RabbitMQService implements AMQPInterface, RabbitMQInterface
{
    public function publish($name, array $value = []): void
    {
        Amqp::publish($name, json_encode(['bank' => (string)config('bank.id')] + $value));
    }

    public function consume(string $queue, string|array $routing, $clojure, $custom = []): void
    {
        $bank = ((string)config('bank.id')) . ".";

        if (is_string($routing)) {
            $routing = [$routing];
        }

        foreach ($routing as $key => $value) {
            $routing[$key] = $bank . $value;
        }

        $routing = [
            'routing' => $routing,
        ];

        do {
            Amqp::consume(
                $bank . $queue,
                function ($message, $resolver) use ($queue, $clojure) {
                    try {
                        $clojure($message->body);
                        $resolver->acknowledge($message);
                    } catch (Throwable $e) {
                        Log::error("Error consumer {$queue}: " . $e->getMessage() . json_encode($e->getTrace()));
                    }
                    $resolver->stopWhenProcessed();
                },
                $custom + $routing
            );
            sleep(10);
        } while (true);
    }
}
