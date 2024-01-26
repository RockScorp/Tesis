<?php

namespace App\Http\Controllers;

use App\Models\Table_1;
use App\Models\Table_2;
use App\Models\Table_3_4;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesisController extends Controller
{
    //================= table 1 y 2

    public function get_tabla_1(){
        $variable=Table_1::where('state','A')->with('table_2')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    public function create_tabla_1(Request $rqt){
        try {
            DB::beginTransaction();
            $tab1=Table_1::updateOrCreate([ //proveedor
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
                // "campo_4"=>$rqt->campo_4,  //campo q se dejará de usar (contacto)
            ],[
                "state"=>"A"
            ]);

            $var=$rqt->table_2;
            foreach($var as $var_req){
                Table_2::create([   //contacto
                    "campo_1"=>$var_req["tb2_campo_1"],
                    "table_1_id"=>$tab1->id,
                ]);
            }
            DB::commit();
            return response()->json(["Msg"=>"Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function update_tabla_1(Request $rqt, $id){
        try {
            DB::beginTransaction();
            // return $rqt;
            $tab1=Table_1::where('state','A')->with('table_2')->find($id);
            if (!$tab1) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab1->fill([ //proveedor
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
                // "campo_4"=>$rqt->campo_4,  //campo q se dejará de usar (contacto)
            ])->save();

            if($tab1->table_2){
                DB::table('table_2')->where('table_1_id', $id)->update(['state' => 'I']);
                $var=$rqt->table_2;
                // return $var;
                foreach($var as $var_req){
                    // return $var_req;
                    if (Table_2::where('table_1_id','!=',$id)->where('campo_1', $var_req["tb2_campo_1"])->first()) return response()->json(["Error" => "Contacto ingresado ya existe en otro Proveedor..."]);
                    Table_2::updateOrCreate([   //contacto
                        "campo_1"=>$var_req["tb2_campo_1"],
                        "table_1_id"=>$id,
                    ],[
                        "state"=>'A'
                    ]);
                }
            }
            DB::commit();
            return response()->json(["Msg"=>"Registro actualizado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function delete_tabla_1($id){
        try {
            DB::beginTransaction();
            $tab1=Table_1::where('state','A')->with('table_2')->find($id);
            if (!$tab1) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab1->fill([
                "state"=>"I"
            ])->save();
            DB::table('table_2')->where('table_1_id', $id)->update(['state' => 'I']);
            DB::commit();
            return response()->json(["Msg"=>"Registro eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    //================= table 3 y 4

    public function get_tabla_3_4(){
        $variable=Table_3_4::where('state','A')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    public function create_tabla_3_4(Request $rqt){
        try {
            DB::beginTransaction();
            Table_3_4::updateOrCreate([ //  unidad - presentación
                "campo_1"=>$rqt->campo_1,
            ],[
                "state"=>"A"
            ]);

            DB::commit();
            return response()->json(["Msg"=>"Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function update_tabla_3_4(Request $rqt, $id){
        try {
            DB::beginTransaction();
            // return $rqt;
            $tab1=Table_3_4::where('state','A')->find($id);
            if (!$tab1) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab1->fill([ //proveedor
                "campo_1"=>$rqt->campo_1,
            ])->save();

            DB::commit();
            return response()->json(["Msg"=>"Registro actualizado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function delete_tabla_3_4($id){
        try {
            DB::beginTransaction();
            $tab1=Table_3_4::where('state','A')->find($id);
            if (!$tab1) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab1->fill([
                "state"=>"I"
            ])->save();
            DB::commit();
            return response()->json(["Msg"=>"Registro eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }
}
