<?php

declare(strict_types=1);

namespace Bank\Integration;

use CodePix\Bank\Application\integration\PixKeyIntegrationInterface;
use CodePix\Bank\Application\Support\ResponseSupport;

class PixKeyIntegration implements PixKeyIntegrationInterface
{
    public function register(string $bank, string $account, string $kind, string $key): ResponseSupport
    {
        return new ResponseSupport(200, (string)str()->uuid(), []);
    }

    public function addAccount(string $bank, string $name, string $agency, string $number): ResponseSupport
    {
        return new ResponseSupport(200, (string)str()->uuid(), []);
    }

}
