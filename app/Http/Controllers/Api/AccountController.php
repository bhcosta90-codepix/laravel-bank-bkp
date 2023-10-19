<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use CodePix\Bank\Application\UseCase\AccountUseCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    public function store(AccountUseCase $accountUseCase, AccountRequest $accountRequest)
    {
        $response = $accountUseCase->register(
            (string)config('bank.id'),
            $accountRequest->name,
            $accountRequest->agency,
            $accountRequest->password,
        );

        return (new AccountResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
