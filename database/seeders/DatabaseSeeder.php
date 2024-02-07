<?php

namespace Database\Seeders;

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
        $this->call(Table_1_2_Seeder::class);
        $this->call(Table_3_4_Seeder::class);
        $this->call(Table_5_6_Seeder::class);
        $this->call(Table_7_Seeder::class);
    }
}
