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
                'material_id' => 1,
                'quantity' => 10,
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 2,
                'quantity' => 5,
                'status' => 'prestado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 3,
                'quantity' => 8,
                'status' => 'en reparación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 4,
                'quantity' => 3,
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 5,
                'quantity' => 12,
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
