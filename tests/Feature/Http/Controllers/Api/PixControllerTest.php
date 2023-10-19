<?php

declare(strict_types=1);

use App\Models\Account;

use CodePix\Bank\Application\Integration\PixKeyIntegrationInterface;

use CodePix\Bank\Application\Support\ResponseSupport;
use Tests\Stubs\Integration\PixKeyIntegration;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->account = Account::factory()->create();
});

describe("PixController Unit Test", function () {
    test("store", function () {
        $mockintegration = mock(\Bank\Integration\PixKeyIntegration::class);

        $id = (string) str()->uuid();

        mockAction($mockintegration, [
            'register' => fn() => new ResponseSupport(200, $id, null),
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
