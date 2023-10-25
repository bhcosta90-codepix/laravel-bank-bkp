<?php

namespace App\Console\Commands\Transaction;

use App\Jobs\Transaction\ConfirmationJob;
use App\Services\Interfaces\RabbitMQInterface;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Illuminate\Console\Command;

class ErrorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:error';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marking a transaction in error';

    /**
     * Execute the console command.
     */
    public function handle(RabbitMQInterface $rabbitMQService)
    {
        $rabbitMQService->consume(
            "transaction_error",
            "transaction.error",
            function ($message) {
                $data = json_decode($message, true);
                dump($data);
            }
        );
    }
}
