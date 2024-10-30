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
                'student_id' => 1,
                'loan_id' => 1,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'Devuelto',
                'detail' => 'fue entregado completo',
                'expected_return_date' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'loan_id' => 2,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'Devuelto',
                'detail' => 'Fue entregado completo',
                'expected_return_date' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 3,
                'loan_id' => 3,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'Incompleto',
                'detail' => 'Fue entregado incompleto le falto un arduino uno',
                'expected_return_date' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
