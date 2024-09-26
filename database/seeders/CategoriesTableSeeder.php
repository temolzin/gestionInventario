<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
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
                'name' => 'Equipos de Redes y Comunicaciones',
                'description' => 'Descripción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Microcontroladores y Placas de Desarrollo',
                'description' => 'Descripción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sensores y Actuadores para Mecatrónica',
                'description' => 'Descripción',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
