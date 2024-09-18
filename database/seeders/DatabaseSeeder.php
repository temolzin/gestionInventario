<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User;
        $user -> name ='Admin';
        $user -> email ='leonardodanieltellez05@gmail.com';
        $user -> password ='1234';
        $user -> role = 'admin';

        $user-> save();
    }
}
