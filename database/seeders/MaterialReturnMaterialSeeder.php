<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialReturnMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('material_return_materials')->insert([
            [
                'material_return_id' => 1,
                'material_id' => 2,
                'quantity_returned' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_return_id' => 1,
                'material_id' => 4,
                'quantity_returned' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_return_id' => 2,
                'material_id' => 3,
                'quantity_returned' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_return_id' => 2,
                'material_id' => 5,
                'quantity_returned' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_return_id' => 3,
                'material_id' => 1,
                'quantity_returned' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_return_id' => 3,
                'material_id' => 6,
                'quantity_returned' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
