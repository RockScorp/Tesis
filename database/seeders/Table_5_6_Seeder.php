<?php

namespace Database\Seeders;

use App\Models\Table_5_6;
use Illuminate\Database\Seeder;

class Table_5_6_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Table_5_6::create([
            "campo_1"=>"servicio fijo example 1", //luz / agua ?
            "campo_2"=>"descripción example 1",
            "table_3_id"=>1
        ]);
        Table_5_6::create([
            "campo_1"=>"servicio fijo example 2",
            "campo_2"=>"descripción example 2",
            "table_3_id"=>null
        ]);

        Table_5_6::create([
            "campo_1"=>"servicio variable example 1", //luz / agua ?
            "campo_2"=>"descripción example 1",
            "table_3_id"=>2
        ]);
        Table_5_6::create([
            "campo_1"=>"servicio variable example 2",
            "campo_2"=>"descripción example 2",
            "table_3_id"=>null
        ]);
    }
}
