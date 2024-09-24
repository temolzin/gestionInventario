<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StudentsTableSeeder::class,
            LoansTableSeeder::class,
            MaterialReturnsTableSeeder::class,
            CategoriesTableSeeder::class,
            InventoriesTableSeeder::class,
            MaterialsTableSeeder::class,
            LoanDetailsTableSeeder::class,
        ]);
    }
}
