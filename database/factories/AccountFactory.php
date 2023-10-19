<?php

namespace Database\Factories;

use App\Models\Agency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agency_id' => Agency::factory(),
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber(8),
            'password' => '$2y$10$rjNzVzAokxMJiCzV0HkUluWZRbp.ZE4BrIJ3TtxwX3Jq1QJ7W0sAS',
        ];
    }
}
