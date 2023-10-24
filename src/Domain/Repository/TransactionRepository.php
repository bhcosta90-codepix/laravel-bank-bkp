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
        return $this->register($transaction, TypeTransactionEnum::DEBIT);
    }

    public function save(Transaction $transaction): bool
    {
        dd('Implement save() method.');
    }

    public function find(string $id): ?Transaction
    {
        dd('Implement find() method.');
    }

    /**
     * @param Transaction $transaction
     * @return bool
     */
    private function register(Transaction $transaction, TypeTransactionEnum $type): bool
    {
        return (bool)\App\Models\Transaction::create([
            'id' => $transaction->id(),
            'account_id' => $transaction->accountFrom->id(),
            'value' => $transaction->value,
            'type' => $type,
            'kind' => $transaction->pixKeyTo->kind,
            'key' => $transaction->pixKeyTo->key,
            'description' => $transaction->description,
            'status' => $transaction->status,
        ]);
    }

}
