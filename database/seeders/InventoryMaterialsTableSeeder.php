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

        foreach (range(1, 50) as $index) {
            DB::table('inventory_material')->insert([
                'inventory_id' => $faker->randomElement($inventoryIds),
                'material_id'  => $faker->randomElement($materialIds),
                'quantity'     => $faker->numberBetween(1, 50),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
