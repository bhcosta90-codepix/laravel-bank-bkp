<?php

declare(strict_types=1);

namespace Bank\Domain\Repository;

use App\Models\Enum\Transaction\TypeTransactionEnum;
use CodePix\Bank\Domain\Entities\Transaction;
use CodePix\Bank\Domain\Repository\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function registerDebit(Transaction $transaction): bool
    {
        return (bool) \App\Models\Transaction::create([
            'account_id' => $transaction->accountFrom->id(),
            'value' => $transaction->value,
            'type' => TypeTransactionEnum::DEBIT,
            'kind' => $transaction->pixKeyTo->kind,
            'key' => $transaction->pixKeyTo->key,
            'description' => $transaction->description,
            'status' => $transaction->status,
        ]);
    }

    public function save(Transaction $transaction): bool
    {
        dd('Implement save() method.');
    }

    public function find(string $id): ?Transaction
    {
        dd('Implement find() method.');
    }

}
