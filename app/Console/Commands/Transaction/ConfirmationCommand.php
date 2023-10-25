<?php

namespace App\Console\Commands\Transaction;

use App\Services\Interfaces\RabbitMQInterface;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Illuminate\Console\Command;

class ConfirmationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:confirmation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating a new transaction';

    /**
     * Execute the console command.
     */
    public function handle(RabbitMQInterface $rabbitMQService, TransactionUseCase $transactionUseCase)
    {
        $rabbitMQService->consume(
            "transaction_confirmation",
            "transaction.confirmation",
            function ($message) use ($transactionUseCase) {
                $data = json_decode($message, true);
                $transactionUseCase->confirmTransaction($data['id']);
            }
        );
    }
}
