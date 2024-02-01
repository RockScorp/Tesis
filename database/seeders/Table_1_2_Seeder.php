<?php

namespace Database\Seeders;

use App\Models\Table_1;
use App\Models\Table_2;
use Illuminate\Database\Seeder;

class Table_1_2_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tab1=Table_1::firstOrCreate([
            'campo_1'=>"Nombre 1",
            'campo_2'=>"Apellido 1",
            'campo_3'=>"Empresa S.A.C. 1"
        ]);
        Table_2::firstOrCreate([
            'campo_1'=>"+51 975616111",
            'table_1_id'=>$tab1->id
        ]);
        Table_2::firstOrCreate([
            'campo_1'=>"contacto@gmail.com 1",
            'table_1_id'=>$tab1->id
        ]);

        $tab2=Table_1::firstOrCreate([
            'campo_1'=>"Nombre 2",
            'campo_2'=>"Apellido 2",
            'campo_3'=>"Empresa S.A.C. 2"
        ]);
        Table_2::firstOrCreate([
            'campo_1'=>"+51 975616222",
            'table_1_id'=>$tab2->id
        ]);
        Table_2::firstOrCreate([
            'campo_1'=>"contacto@gmail.com 2",
            'table_1_id'=>$tab2->id
        ]);
    }
}
