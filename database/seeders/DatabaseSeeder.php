<?php

namespace Database\Seeders;

// use Illuminate\TransactionInterface\Console\Seeds\WithoutModelEvents;
use App\Models\Agency;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Agency::factory()->create(['code' => '0001']);
    }
}
