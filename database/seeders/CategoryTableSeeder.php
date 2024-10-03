<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'department_id' => 1,
                'created_by' => 2,
                'name' => 'Equipos de Redes y Comunicaciones',
                'description' => 'Descripción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'created_by' => 2,
                'name' => 'Microcontroladores y Placas de Desarrollo',
                'description' => 'Descripción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'created_by' => 2,
                'name' => 'Sensores y Actuadores para Mecatrónica',
                'description' => 'Descripción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
