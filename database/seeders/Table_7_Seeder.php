<?php

namespace Database\Seeders;

use App\Models\Table_7;
use Illuminate\Database\Seeder;

class Table_7_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Table_7::create([
            "campo_1"=> "materia prima example 1",
            "campo_2"=> "descripcion example 1",
            "campo_3"=> "codigo example 1",
            "table_4_id"=> 3,
            "campo_4"=> "25", //stock
        ]);
        Table_7::create([
            "campo_1"=> "materia prima example 2",
            "campo_2"=> "descripcion example 2",
            "campo_3"=> "codigo example 2",
            "table_4_id"=> 4,
            "campo_4"=> "36", //stock
        ]);
    }
}
