<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_details')->insert([
            [
                'loan_id' => 1,
                'material_id' => 1,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 2,
                'material_id' => 2,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 3,
                'material_id' => 3,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 4,
                'material_id' => 4,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 5,
                'material_id' => 5,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 6,
                'material_id' => 6,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 7,
                'material_id' => 7,
                'department_id' => 1,
                'created_by' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
