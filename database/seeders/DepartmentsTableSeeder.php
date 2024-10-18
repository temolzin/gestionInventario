<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'Biología Molecular',
                'description' => 'Laboratorio dedicado a la investigación en biología molecular.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Química Analítica',
                'description' => 'Laboratorio especializado en análisis químico de muestras.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Física Aplicada',
                'description' => 'Laboratorio centrado en aplicaciones prácticas de la física.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ingeniería Electrónica',
                'description' => 'Laboratorio enfocado en el desarrollo de circuitos electrónicos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ciencias de la Computación',
                'description' => 'Laboratorio dedicado a la investigación en ciencias de la computación.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
