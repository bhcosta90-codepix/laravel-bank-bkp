<?php

declare(strict_types=1);

use App\Console\Commands\Transaction\CreateCommand;
use App\Models\Account;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Tests\Stub\Services\RabbitMQService;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->data = '{"bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","account_from":"9a7246c5-2747-46c2-9b44-6ba56b83be95","value":10,"pix_key_to":{"bank":"ea9b5815-1b04-4d34-87e1-16da2787a3bb","account":"9a7246c5-2840-46f2-b9a2-9b5ab68832a9","kind":"id","key":"6860b687-a250-4154-8a55-3d603af2e916","status":true,"id":"9a728c44-5438-4e50-9d12-fe0431c59469","created_at":"2023-10-24 14:15:02","updated_at":"2023-10-24 14:15:02"},"description":"testing","status":"pending","cancel_description":null,"id":"018b62ae-c382-72b8-92c4-ad1adfb599bc","created_at":"2023-10-24 14:15:02","updated_at":"2023-10-24 14:15:02"}';
    $this->command = new CreateCommand();

    Account::factory()->create([
        'id' => '9a7246c5-2747-46c2-9b44-6ba56b83be95'
    ]);
});

describe("CreateCommand Feature Test", function () {
    test("handle", function () {
        $this->command->handle(new RabbitMQService($this->data), app(TransactionUseCase::class));

        assertDatabaseHas('transactions', [
            'account_id' => '9a7246c5-2747-46c2-9b44-6ba56b83be95',
            'value' => 10,
            'type' => 0,
            'kind' => 'id',
            'key' => '6860b687-a250-4154-8a55-3d603af2e916',
            'description' => 'testing',
            'status' => 'pending',
            'debit_id' => '018b62ae-c382-72b8-92c4-ad1adfb599bc',
            'cancel_description' => null,
        ]);
    });
});
