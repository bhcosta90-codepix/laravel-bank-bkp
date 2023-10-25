<?php

declare(strict_types=1);

namespace Bank\Domain\Repository;

use App\Models\Account as ModelAlias;
use App\Models\Agency;
use BRCas\CA\ValueObject\Password;
use CodePix\Bank\Domain\Entities\Account;
use CodePix\Bank\Domain\Entities\Enum\PixKey\KindPixKey;
use CodePix\Bank\Domain\Entities\PixKey;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;
use Costa\Entity\ValueObject\Uuid;

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

    public function findKeyByKind(string $kind, string $key, $locked = false): ?PixKey
    {
        $bank = [
            'bank' => config('bank.id'),
        ];

        $pix = $locked
            ? \App\Models\PixKey::lockForUpdate()->where('key', $key)->where('kind', $kind)->first()
            : \App\Models\PixKey::where('key', $key)->where('kind', $kind)->first();

        if ($pix) {
            $accountDb = $pix->account;

            $account = Account::make(
                [
                    'password' => new Password($accountDb->password),
                    'agency' => new Uuid($accountDb->agency_id),
                    'balance' => $accountDb->balance,
                ] + $accountDb->toArray() + $bank
            );

            return PixKey::make(
                [
                    'account' => $account,
                    'kind' => KindPixKey::from($pix->kind),
                ] + $bank + $pix->toArray()
            );
        }

        return null;
    }

    public function addAccount(Account $account): void
    {
        $data = $account->toArray();
        $this->account->create($data + ['agency_id' => $data['agency']]);
    }

    public function findAccount(string $id, bool $locked): ?Account
    {
        $account = $locked
            ? \App\Models\Account::lockForUpdate()->find($id)
            : \App\Models\Account::find($id);

        if ($account) {
            return Account::make(
                [
                    'bank' => config('bank.id'),
                    'agency' => new Uuid($account->agency->id),
                    'password' => new Password($account->password),
                ] + $account->toArray()
            );
        }

        return null;
    }

    public function updateAccount(Account $account): bool
    {
        return \App\Models\Account::find($account->id())->update([
            'balance' => $account->balance,
        ]);
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
