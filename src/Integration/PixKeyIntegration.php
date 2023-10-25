<?php

declare(strict_types=1);

namespace Bank\Integration;

use CodePix\Bank\Application\Integration\PixKeyIntegrationInterface;
use CodePix\Bank\Application\Integration\Response\ResponseKeyValueOutput;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PixKeyIntegration implements PixKeyIntegrationInterface
{
    /**
     * @throws ValidationException
     */
    public function register(string $bank, string $account, string $kind, ?string $key): ResponseKeyValueOutput
    {
        $response = Http::acceptJson()->post(config('system.api.endpoint') . '/api/account/' . $account . '/pix', [
            'bank' => $bank,
            'kind' => $kind,
            'key' => $key,
        ]);

        if ($response->status() === 422) {
            throw ValidationException::withMessages($response->json('errors'));
        }

        return new ResponseKeyValueOutput($response->json('data.id'), $response->json('data.key'), $response->status());
    }
}
