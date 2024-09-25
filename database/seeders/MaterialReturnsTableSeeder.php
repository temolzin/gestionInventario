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
                'status' => 'buenas condiciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'loan_id' => 2,
                'status' => 'pendiente de revisión',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 3,
                'loan_id' => 3,
                'status' => 'dañado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
