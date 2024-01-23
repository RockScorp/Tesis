<?php

namespace App\Http\Controllers;

use App\Models\Table_1;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesisController extends Controller
{
    public function get_tabla_1(){
        $variable=Table_1::with('table_2')->get();
        if(count($variable)==0) return response()->json(["No hay Registros..."]);
        return response()->json($variable);
    }

    public function create_table_2(Request $rqt){
        try {
            DB::beginTransaction();
            Table_1::create([
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
                // "table_2_id"=>$rqt->table_2_id,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }
}
