<?php

declare(strict_types=1);

use App\Models\Agency;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(fn() => $this->agency = Agency::factory()->create(['code' => '0001']));

describe("AccountController Unit Test", function () {
    test("store", function () {
        $response = postJson('/api/account', [
            'agency' => '0001',
            'name' => 'testing',
            'password' => 'testing-123456',
            'password_confirmation' => 'testing-123456',
        ]);

        assertDatabaseHas('accounts', [
            'id' => $response->json('data.id'),
            'agency_id' => $this->agency->id,
            'name' => 'testing',
        ]);
    });
});
