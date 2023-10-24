<?php

declare(strict_types=1);

namespace App\Models\Enum\Transaction;

enum TypeTransactionEnum: int
{
    case CREDIT = 0;

    case DEBIT = 1;
}
