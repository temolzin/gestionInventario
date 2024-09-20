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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 2,
                'material_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 3,
                'material_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 4,
                'material_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 5,
                'material_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 6,
                'material_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 7,
                'material_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 8,
                'material_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 9,
                'material_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'loan_id' => 10,
                'material_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
