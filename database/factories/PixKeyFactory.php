<?php

namespace Database\Factories;

use App\Models\Account;
use CodePix\Bank\Domain\Entities\Enum\PixKey\KindPixKey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PixKey>
 */
class PixKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => str()->uuid(),
            'account_id' => Account::factory(),
            'kind' => KindPixKey::ID,
            'key' => str()->uuid(),
        ];
    }
}
