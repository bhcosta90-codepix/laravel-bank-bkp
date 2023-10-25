<?php

namespace App\Jobs\Transaction;

use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ErrorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $id, protected string $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TransactionUseCase $transactionUseCase): void
    {
        $transactionUseCase->errorTransaction($this->id, $this->message);
    }
}
