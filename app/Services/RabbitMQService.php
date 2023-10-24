<?php

declare(strict_types=1);

namespace App\Services;

use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Facades\Log;
use Throwable;

class RabbitMQService implements AMQPInterface
{
    public function publish($name, array $value = []): void
    {
        Amqp::publish($name, json_encode([
            'bank' => (string) config('bank.id')
            ] + $value));
    }

    public function consume(string $queue, string|array $routing, $clojure, $custom = [])
    {
        if (is_string($routing)) {
            $routing = [$routing];
        }

        $routing = [
            'routing' => $routing,
        ];

        do {
            Amqp::consume($queue, function ($message, $resolver) use ($queue, $clojure) {
                try {
                    $clojure($message->body);
                } catch (Throwable $e) {
                    Log::error("Error consumer {$queue}: " . $e->getMessage() . json_encode($e->getTrace()));
                }
                $resolver->stopWhenProcessed();
            }, $custom + $routing);
            sleep(10);
        } while (true);
    }
}
