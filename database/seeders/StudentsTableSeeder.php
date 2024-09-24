<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            [
                'enrollment' => 2523260001,
                'name' => 'Juan',
                'last_name' => 'Pérez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260002,
                'name' => 'María',
                'last_name' => 'García',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260003,
                'name' => 'Carlos',
                'last_name' => 'López',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260004,
                'name' => 'Ana',
                'last_name' => 'Fernández',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260005,
                'name' => 'Luis',
                'last_name' => 'Martínez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260006,
                'name' => 'Laura',
                'last_name' => 'Gómez',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260007,
                'name' => 'Miguel',
                'last_name' => 'Hernández',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260008,
                'name' => 'Sofía',
                'last_name' => 'Ruiz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260009,
                'name' => 'David',
                'last_name' => 'Torres',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'enrollment' => 2523260010,
                'name' => 'Elena',
                'last_name' => 'Mendoza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
