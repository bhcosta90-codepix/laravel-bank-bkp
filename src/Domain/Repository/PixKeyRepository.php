<?php

declare(strict_types=1);

namespace Bank\Domain\Repository;

use App\Models\Account as ModelAlias;
use App\Models\Agency;
use BRCas\CA\ValueObject\Password;
use CodePix\Bank\Domain\Entities\Account;
use CodePix\Bank\Domain\Entities\PixKey;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;

class PixKeyRepository implements PixKeyRepositoryInterface
{

    public function __construct(
        protected Agency $agency,
        protected ModelAlias $account,
        protected \App\Models\PixKey $pixKey
    ) {
    }

    public function register(PixKey $pixKey): bool
    {
        return (bool)$this->pixKey->create([
            'id' => $pixKey->id(),
            'reference' => $pixKey->reference,
            'account_id' => $pixKey->account->id(),
            'kind' => $pixKey->kind,
            'key' => $pixKey->key,
        ]);
    }

    public function findKeyByKind(string $key, string $kind): ?PixKey
    {
        throw new \Exception();
    }

    public function addAccount(Account $account): void
    {
        $data = $account->toArray();
        $this->account->create($data + ['agency_id' => $data['agency']]);
    }

    public function findAccount(string $id): ?Account
    {
        if ($account = \App\Models\Account::find($id)) {
            return Account::make(
                [
                    'bank' => config('bank.id'),
                    'agency' => $account->agency->id,
                    'password' => new Password($account->password),
                ] + $account->toArray()
            );
        }

        return null;
    }

    public function verifyNumber(string $agency, string $number): bool
    {
        return (bool)$this->agency
            ->where('agency_id', $agency)
            ->where('number', $number)
            ->count();
    }

    public function getAgencyByCode(string $id): ?string
    {
        return Agency::where('code', $id)->first()?->id;
    }
}
