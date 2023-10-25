<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\PixKey;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->account = Account::factory()->create();
    $this->pix = PixKey::factory()->create();
});

describe("TransactionController Unit Test", function () {
    test("store", function () {
        $response = $this->postJson('/api/account/' . $this->account->id . '/transaction', [
            'description' => 'testing',
            'value' => 10,
            'kind' => $this->pix->kind->value,
            'key' => (string) $this->pix->key,
        ]);

        assertDatabaseHas('transactions', [
            'id' => $response->json('data.id'),
            'account_id' => $this->account->id,
            'value' => 10,
            'type' => 1,
            'kind' => $this->pix->kind->value,
            'key' => $this->pix->key,
            'description' => 'testing',
        ]);
    });
});
