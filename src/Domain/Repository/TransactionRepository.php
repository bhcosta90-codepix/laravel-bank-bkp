<?php

declare(strict_types=1);

namespace Bank\Domain\Repository;

use CodePix\Bank\Domain\Entities\Transaction;
use CodePix\Bank\Domain\Repository\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function register(Transaction $transaction): bool
    {
        dd('Implement register() method.');
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
