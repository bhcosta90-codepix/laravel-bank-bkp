<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use CodePix\Bank\Application\UseCase\TransactionUseCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function store(TransactionRequest $transactionRequest, TransactionUseCase $transactionUseCase)
    {
        $response = $transactionUseCase->registerDebit(
            account: $transactionRequest->account,
            value: $transactionRequest->value,
            kind: $transactionRequest->kind,
            key: $transactionRequest->key,
            description: $transactionRequest->description,
        );

        return (new TransactionResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Request $request, TransactionUseCase $transactionUseCase)
    {
        $response = $transactionUseCase->find($request->transaction);

        return (new TransactionResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function index(string $account, TransactionUseCase $transactionUseCase)
    {
        $response = $transactionUseCase->index($account);
        return TransactionResource::collection($response->items());
    }
}
