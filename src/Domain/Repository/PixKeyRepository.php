<?php

declare(strict_types=1);

namespace Bank\Domain\Repository;

use App\Models\Account as ModelAlias;
use App\Models\Agency;
use CodePix\Bank\Domain\Entities\Account;
use CodePix\Bank\Domain\Entities\PixKey;
use CodePix\Bank\Domain\Repository\PixKeyRepositoryInterface;

class PixKeyRepository implements PixKeyRepositoryInterface
{

    public function __construct(protected Agency $agency, protected ModelAlias $account)
    {
    }

    public function register(PixKey $pixKey): bool
    {
        throw new \Exception();
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
        throw new \Exception();
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
