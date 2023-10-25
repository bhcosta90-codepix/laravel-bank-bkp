<?php

declare(strict_types=1);

namespace Bank\TransactionInterface;

use BRCas\CA\Contracts\Transaction\DatabaseTransactionInterface;
use Illuminate\Support\Facades\DB;

class DatabaseTransaction implements DatabaseTransactionInterface
{

    public function __construct()
    {
        DB::beginTransaction();;
    }

    public function commit(): void
    {
        DB::commit();;
    }

    public function rollback(): void
    {
        DB::rollBack();
    }
}
