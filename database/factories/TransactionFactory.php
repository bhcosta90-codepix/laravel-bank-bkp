<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'value' => rand(100, 999),
            'type' => 0,
            'kind' => 'id',
            'key' => str()->uuid(),
            'description' => $this->faker->sentence(5),
            'status' => 'pending',
        ];
    }
}
