<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Customer::factory()
            ->count(10)
            ->create();

        Product::factory()
            ->count(100)
            ->create();
    }
}
