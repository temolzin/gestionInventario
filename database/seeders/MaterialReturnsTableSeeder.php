<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialReturnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('material_returns')->insert([
            [
                'loan_id' => 1, 
                'department_id' => 1, 
                'created_by' => 2, 
                'return_at' => now()->addDays(1)->format('Y-m-d H:i:s'), 
                'status' => 'Devuelto', 
                'detail' => 'Material entregado completo', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 2,
                'department_id' => 1,
                'created_by' => 2, 
                'return_at' => now()->addDays(1)->format('Y-m-d H:i:s'), 
                'status' => 'Devuelto', 
                'detail' => 'Material entregado completo', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 3, 
                'department_id' => 1, 
                'created_by' => 2, 
                'return_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'status' => 'Incompleto', 
                'detail' => 'Faltaba un componente esencial', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
