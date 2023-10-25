<?php

declare(strict_types=1);

namespace Bank\Domain\Repository;

use App\Models\Enum\Transaction\TypeTransactionEnum;
use App\Models\Presenters\PaginationPresenter;
use BRCas\CA\Contracts\Items\PaginationInterface;
use BRCas\CA\ValueObject\Password;
use CodePix\Bank\Domain\Entities\Account;
use CodePix\Bank\Domain\Entities\Enum\PixKey\KindPixKey;
use CodePix\Bank\Domain\Entities\Enum\Transaction\StatusTransaction;
use CodePix\Bank\Domain\Entities\Transaction;
use CodePix\Bank\Domain\Repository\TransactionRepositoryInterface;
use Costa\Entity\ValueObject\Uuid;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function registerDebit(Transaction $transaction): bool
    {
        return $this->register($transaction, TypeTransactionEnum::DEBIT);
    }

    public function registerCredit(Transaction $transaction): bool
    {
        return $this->register($transaction, TypeTransactionEnum::CREDIT);
    }

    public function save(Transaction $transaction): bool
    {
        if($rs = \App\Models\Transaction::find($transaction->id())){
            return $rs->update([
                'status' => $transaction->status->value,
            ]);
        }

        return false;
    }

    public function find(string $id): ?Transaction
    {
        if($transaction = \App\Models\Transaction::find($id)){

            $dataAccount = [
                'bank' => config('bank.id'),
                'agency' => new Uuid($transaction->account->agency_id),
                'password' => new Password($transaction->account->password),
            ];

            $data = [
                'kind' => KindPixKey::from($transaction->kind),
                'status' => StatusTransaction::from($transaction->status),
                'accountFrom' => Account::make($dataAccount + $transaction->account->toArray()),
            ];
            return Transaction::make($data + $transaction->toArray());
        }

        return null;
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
            'kind' => $transaction->kind,
            'key' => $transaction->key,
            'description' => $transaction->description,
            'status' => $transaction->status,
            'debit_id' => $transaction->debit,
        ]);
    }

    public function getAll(string $account): PaginationInterface
    {
        $result = \App\Models\Transaction::where('account_id', $account)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return new PaginationPresenter($result);
    }


}
