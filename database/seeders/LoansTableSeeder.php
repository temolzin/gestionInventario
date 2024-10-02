<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loans')->insert([
            [
                'student_id' => 1,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'buenas condiciones',
                'detail' => 'practica de laboratorio',
                'return_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'created_at' => now()->subDay()->format('Y-m-d H:i:s'),
                'updated_at' => now()->subDay()->format('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 2,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'pendiente de revisión',
                'detail' => 'uso de equipo en clase',
                'return_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'created_at' => now()->subDay()->format('Y-m-d H:i:s'),
                'updated_at' => now()->subDay()->format('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 3,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'dañado',
                'detail' => 'experimento de química',
                'return_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'created_at' => now()->subDay()->format('Y-m-d H:i:s'),
                'updated_at' => now()->subDay()->format('Y-m-d H:i:s'),
            ],
            [
                'student_id' => 4,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'buenas condiciones',
                'detail' => 'uso en proyecto final',
                'return_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 5,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'reparación requerida',
                'detail' => 'fallo en uso del equipo',
                'return_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 6,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'buenas condiciones',
                'detail' => 'práctica de electrónica',
                'return_at' => now()->addDays(2)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 7,
                'department_id' => 1,
                'created_by' => 2,
                'status' => 'pendiente de devolución',
                'detail' => 'proyecto de ingeniería',
                'return_at' => now()->addDays(1)->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
