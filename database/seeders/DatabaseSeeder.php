<?php

namespace Database\Seeders;

use App\Infrastructure\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Product::factory()->count(10)->create();
    }
}
