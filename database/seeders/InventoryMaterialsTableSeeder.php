<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryMaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventory_material')->insert([
            ['inventory_id' => 1, 'material_id' => 1, 'quantity' => 10],
            ['inventory_id' => 1, 'material_id' => 2, 'quantity' => 5],
            ['inventory_id' => 2, 'material_id' => 3, 'quantity' => 8],
            ['inventory_id' => 2, 'material_id' => 1, 'quantity' => 12],
            ['inventory_id' => 3, 'material_id' => 2, 'quantity' => 20],
            ['inventory_id' => 3, 'material_id' => 4, 'quantity' => 3],
            ['inventory_id' => 4, 'material_id' => 5, 'quantity' => 15],
            ['inventory_id' => 4, 'material_id' => 6, 'quantity' => 7],
            ['inventory_id' => 5, 'material_id' => 1, 'quantity' => 9],
            ['inventory_id' => 5, 'material_id' => 7, 'quantity' => 11],
            ['inventory_id' => 2, 'material_id' => 2, 'quantity' => 18],
            ['inventory_id' => 2, 'material_id' => 8, 'quantity' => 4],
            ['inventory_id' => 3, 'material_id' => 3, 'quantity' => 13],
            ['inventory_id' => 3, 'material_id' => 9, 'quantity' => 16],
            ['inventory_id' => 4, 'material_id' => 10, 'quantity' => 25],
        ]);
    }
}
