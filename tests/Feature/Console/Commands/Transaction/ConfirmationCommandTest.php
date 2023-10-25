<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\ConfirmationCommand;
use App\Models\Account;
use App\Models\Transaction;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->command = new ConfirmationCommand();

    $this->transaction = Transaction::factory()->create([
        'id' => '018b66cb-a1c2-73d4-af03-8656e51bf710',
        'value' => 50,
    ]);
});
describe("ConfirmationCommand Feature Test", function(){
    test("handle", function(){
        $this->command->handle(new RabbitMQService("transaction:confirmation"), app(TransactionUseCase::class));
        assertDatabaseHas('transactions', [
            'status' => 'completed',
        ]);

        assertDatabaseHas('accounts', [
           'id' => $this->transaction->account_id,
           'balance' => -50,
        ]);
    });
});
