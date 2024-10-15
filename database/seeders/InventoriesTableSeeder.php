<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventories')->insert([
            [
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'no disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'no disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
