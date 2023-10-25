<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\ConfirmationCommand;
use App\Console\Commands\Transaction\CreateCommand;
use App\Models\Account;
use App\Models\Transaction;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function(){
    $this->account1 = Account::factory()->create([
        'id' => '018b6333-2612-713c-8b6d-6e7574f2c727',
        'name' => 'testing account_id',
        'balance' => -10,
    ]);

    $this->account2 = Account::factory()->create([
        'id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
        'name' => 'testing pix key',
        'balance' => 10,
    ]);
    $this->account2->pix()->create([
        'reference' => str()->uuid(),
        'kind' => 'id',
        'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
    ]);

    Transaction::factory()->create([
        'id' => '018b66cb-a1c2-73d4-af03-8656e51bf710',
        'account_id' => $this->account1->id,
        'value' => 10,
        'kind' => 'id',
        'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
    ]);
});

describe("Testing all commands to transaction", function () {
    test("handle", function () {
        $commandCreate = new CreateCommand();
        $commandCreate->handle(new RabbitMQService("transaction:create"), app(TransactionUseCase::class));

        assertDatabaseHas(Account::class, [
            'id' => '9a7246c5-2840-46f2-b9a2-9b5ab68832a9',
            'balance' => 20,
        ]);

        $commandConfirmation = new ConfirmationCommand();
        $commandConfirmation->handle(new RabbitMQService("transaction:confirmation"), app(TransactionUseCase::class));

        assertDatabaseHas(Account::class, [
            'id' => '018b6333-2612-713c-8b6d-6e7574f2c727',
            'balance' => -20,
        ]);
    });
});
