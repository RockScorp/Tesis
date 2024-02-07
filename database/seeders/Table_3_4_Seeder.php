<?php

namespace Database\Seeders;

use App\Models\Table_3_4;
use Illuminate\Database\Seeder;

class Table_3_4_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Table_3_4::firstOrCreate([
            "campo_1"=>"unidad example 1"
        ]);
        Table_3_4::firstOrCreate([
            "campo_1"=>"unidad example 2"
        ]);
        Table_3_4::firstOrCreate([
            "campo_1"=>"presentación example 1"
        ]);
        Table_3_4::firstOrCreate([
            "campo_1"=>"presentación example 2"
        ]);
    }
}
