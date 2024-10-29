<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $departmentIds = DB::table('departments')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        foreach (range(1, 10) as $index) {
            DB::table('inventories')->insert([
                'department_id' => 1,
                'created_by'    => $faker->randomElement($userIds),
                'status'        => $faker->randomElement(['disponible', 'no disponible']),
                'detail'        => $faker->sentence,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
