<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PixRequest;
use App\Http\Resources\PixResource;
use CodePix\Bank\Application\UseCase\PixUseCase;
use Symfony\Component\HttpFoundation\Response;

class PixKeyController extends Controller
{
    public function store(string $account, PixUseCase $pixUseCase, PixRequest $pixRequest)
    {
        $response = $pixUseCase->register(kind: $pixRequest->kind, key: $pixRequest->key, account: $account);

        return (new PixResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
