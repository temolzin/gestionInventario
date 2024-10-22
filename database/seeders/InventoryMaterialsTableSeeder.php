<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InventoryMaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $inventoryIds = DB::table('inventories')->pluck('id')->toArray();
        $materialIds = DB::table('materials')->pluck('id')->toArray();
        $totalRecords = 30;
        $currentRecords = 0;

        while ($currentRecords < $totalRecords) {
            foreach ($inventoryIds as $inventoryId) {
                if ($currentRecords >= $totalRecords) break;

                $materialCount = $faker->numberBetween(2, 5);

                $selectedMaterials = $faker->randomElements($materialIds, $materialCount);

                foreach ($selectedMaterials as $materialId) {
                    if ($currentRecords >= $totalRecords) break;

                    DB::table('inventory_material')->insert([
                        'inventory_id' => $inventoryId,
                        'material_id'  => $materialId,
                        'quantity'     => $faker->numberBetween(10, 30),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);

                    $currentRecords++;
                }
            }
        }
    }
}
