<?php

declare(strict_types=1);

namespace Bank\Integration;

use CodePix\Bank\Application\Integration\PixKeyIntegrationInterface;
use CodePix\Bank\Application\Support\ResponseSupport;

class PixKeyIntegration implements PixKeyIntegrationInterface
{
    public function register(string $bank, string $account, string $kind, string $key): ResponseSupport
    {
        dump('entrou');die;
        return new ResponseSupport(200, (string)str()->uuid(), []);
    }
}
