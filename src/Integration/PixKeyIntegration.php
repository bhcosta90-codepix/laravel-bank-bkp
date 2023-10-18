<?php

declare(strict_types=1);

namespace Bank\Integration;

use CodePix\Bank\Application\integration\PixKeyIntegrationInterface;
use CodePix\Bank\Application\Support\ResponseSupport;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PixKeyIntegration implements PixKeyIntegrationInterface
{
    public function register(string $bank, string $account, string $kind, string $key): ResponseSupport
    {
        return new ResponseSupport(200, (string)str()->uuid(), []);
    }

    /**
     * @throws \Exception
     */
    public function addAccount(string $bank, string $name, string $agency, string $number): ResponseSupport
    {
        $response = Http::post(config('system.api.endpoint') . '/api/account', [
            'bank' => $bank,
            'name' => $name,
            'agency' => $agency,
            'number' => $number,
        ]);

        return match (true) {
            $response->status() == 201 => new ResponseSupport(200, $response->json('data.id'), []),
            400 && $response->json('message') => new ResponseSupport(200, $this->getId($response), []),
            default => throw new \Exception(),
        };
    }

    public function getId(Response $response): mixed
    {
        $response = $response->json('message');
        $data = explode(':', $response);

        return trim(end($data));
    }

}
