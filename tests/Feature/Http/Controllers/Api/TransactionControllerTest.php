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

        trace($response);
    });
});
