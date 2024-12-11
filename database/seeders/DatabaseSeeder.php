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
            DepartmentsTableSeeder::class,
            RoleSeeder::class,
            UserSeed::class,
            StudentsTableSeeder::class,
            CategoryTableSeeder::class,
            MaterialsTableSeeder::class,
            LoansTableSeeder::class,
            LoanDetailsTableSeeder::class,
            MaterialReturnsTableSeeder::class,
            InventoriesTableSeeder::class,
            InventoryMaterialsTableSeeder::class,
            MaterialReturnMaterialSeeder::class,
        ]);
    }
}
