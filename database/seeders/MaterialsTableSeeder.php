<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert([
            [
                'category_id' => 1,
                'inventory_id' => 1,
                'name' => 'Router Cisco 2901',
                'description' => 'Router para prácticas de redes avanzadas',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'inventory_id' => 1,
                'name' => 'Router Cisco 2901 (Redundante)',
                'description' => 'Router de respaldo para prácticas de redes',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'inventory_id' => 2,
                'name' => 'Switch HP 2530-24G',
                'description' => 'Switch gestionable para configuración de redes',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'inventory_id' => 3,
                'name' => 'Modem LTE Huawei',
                'description' => 'Modem para prácticas de conectividad LTE',
                'status' => 'prestado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'inventory_id' => 3,
                'name' => 'Modem LTE Huawei (Alternativo)',
                'description' => 'Modem secundario para conectividad LTE',
                'status' => 'prestado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'inventory_id' => 4,
                'name' => 'Antena WiFi TP-Link',
                'description' => 'Antena para extender redes inalámbricas',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'inventory_id' => 5,
                'name' => 'ESP32 Dev Kit',
                'description' => 'Placa de desarrollo para proyectos IoT y mecatrónica',
                'status' => 'en reparación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'inventory_id' => 5,
                'name' => 'Arduino Uno',
                'description' => 'Placa de desarrollo para prácticas de control y automatización',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'inventory_id' => 1,
                'name' => 'Cámara IP Hikvision',
                'description' => 'Cámara de seguridad para monitoreo de redes',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'inventory_id' => 3,
                'name' => 'Sensor de Temperatura DHT11',
                'description' => 'Sensor para monitoreo de temperatura en proyectos de IoT',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'inventory_id' => 4,
                'name' => 'Sensor Ultrasonico HC-SR04',
                'description' => 'Sensor de distancia para proyectos de robótica',
                'status' => 'en reparación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'inventory_id' => 5,
                'name' => 'Raspberry Pi 4',
                'description' => 'Microcomputadora para proyectos de computación y redes',
                'status' => 'prestado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'inventory_id' => 2,
                'name' => 'Multímetro Digital Fluke',
                'description' => 'Multímetro para medición de circuitos eléctricos',
                'status' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
