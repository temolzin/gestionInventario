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
                'name' => 'Computadoras y Tablets',
                'description' => 'Departamento de Computadoras y Tablets',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dispositivos Móviles',
                'description' => 'Departamento de Dispositivos Móviles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Equipos de Red',
                'description' => 'Departamento de Equipos de Red',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Software y Licencias',
                'description' => 'Departamento de Software y Licencias',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Periféricos y Accesorios',
                'description' => 'Departamento de Periféricos y Accesorios',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
