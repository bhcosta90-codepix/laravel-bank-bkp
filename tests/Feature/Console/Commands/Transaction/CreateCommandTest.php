<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\CreateCommand;
use App\Models\Account;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->command = new CreateCommand();

    Account::factory()->create([
        'id' => '018b6333-2612-713c-8b6d-6e7574f2c727'
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
});

describe("CreateCommand Feature Test", function () {
    test("handle", function () {
        $this->command->handle(new RabbitMQService("transaction:create"), app(TransactionUseCase::class));

        assertDatabaseHas('transactions', [
            'account_id' => '018b6333-2612-713c-8b6d-6e7574f2c727',
            'value' => 10,
            'type' => 0,
            'kind' => 'id',
            'key' => 'ea5d1de6-66ff-4110-a21e-4d8e15c4859d',
            'description' => 'testing',
            'status' => 'completed',
            'debit_id' => '018b66cb-a1c2-73d4-af03-8656e51bf710',
            'cancel_description' => null,
        ]);
    });
});
