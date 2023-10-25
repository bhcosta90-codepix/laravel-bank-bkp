<?php

declare(strict_types=1);

use App\Models\Account;
use CodePix\Bank\Application\Integration\Response\ResponseKeyValueOutput;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->account = Account::factory()->create();
});

describe("PixController Unit Test", function () {
    test("store", function () {
        $mockintegration = mock(\Bank\Integration\PixKeyIntegration::class);

        $id = (string)str()->uuid();

        mockAction($mockintegration, [
            'register' => fn() => new ResponseKeyValueOutput($id, "test@test.com", 200),
        ]);

        app()->instance(\Bank\Integration\PixKeyIntegration::class, $mockintegration);

        $response = $this->postJson('/api/account/' . $this->account->id . '/pix', [
            'agency' => '0001',
            'name' => 'testing',
            'kind' => 'email',
            'key' => 'test@test.com',
        ]);

        assertDatabaseHas('pix_keys', [
            'id' => $response->json('data.id'),
            'reference' => $id,
            'account_id' => $this->account->id,
            'kind' => 'email',
            'key' => 'test@test.com',
        ]);
    });
});
