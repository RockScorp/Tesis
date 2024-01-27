<?php

namespace App\Http\Controllers;

use App\Models\Table_1;
use App\Models\Table_2;
use App\Models\Table_3_4;
use App\Models\Table_5_6;
use App\Models\Table_7;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TesisController extends Controller
{
    //================= table 1 y 2

    public function get_tabla_1_2(){
        $variable=Table_1::where('state','A')->with('table_2')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    public function create_tabla_1_2(Request $rqt){
        try {
            DB::beginTransaction();
            $tab=Table_1::updateOrCreate([ //proveedor
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
                    "table_1_id"=>$tab->id,
                ]);
            }
            DB::commit();
            return response()->json(["Msg"=>"Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function update_tabla_1_2(Request $rqt, $id){
        try {
            DB::beginTransaction();
            // return $rqt;
            $tab=Table_1::where('state','A')->with('table_2')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([ //proveedor
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
                // "campo_4"=>$rqt->campo_4,  //campo q se dejará de usar (contacto)
            ])->save();

            if($tab->table_2){
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

    public function delete_tabla_1_2($id){
        try {
            DB::beginTransaction();
            $tab=Table_1::where('state','A')->with('table_2')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
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
            $tab=Table_3_4::where('state','A')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
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
            $tab=Table_3_4::where('state','A')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
                "state"=>"I"
            ])->save();
            DB::commit();
            return response()->json(["Msg"=>"Registro eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    //================= table 5 y 6

    public function get_tabla_5_6(){
        $variable=Table_5_6::where('state','A')->with('table_3')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    public function create_tabla_5_6(Request $rqt){
        try {
            DB::beginTransaction();
            Table_5_6::updateOrCreate([ //  servicio fijo/variable
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "table_3_id"=>$rqt->table_3_id,
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

    public function update_tabla_5_6(Request $rqt, $id){
        try {
            DB::beginTransaction();
            // return $rqt;
            $tab=Table_5_6::where('state','A')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "table_3_id"=>$rqt->table_3_id,
            ])->save();

            DB::commit();
            return response()->json(["Msg"=>"Registro actualizado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function delete_tabla_5_6($id){
        try {
            DB::beginTransaction();
            $tab=Table_5_6::where('state','A')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
                "state"=>"I"
            ])->save();
            DB::commit();
            return response()->json(["Msg"=>"Registro eliminado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    //================= table 7

    public function get_tabla_7(){
        $variable=Table_7::where('state','A')->with('table_4')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    public function create_tabla_7(Request $rqt){
        try {
            DB::beginTransaction();
            Table_7::updateOrCreate([ //  Materia Prima
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
                "table_4_id"=>$rqt->table_4_id,
                "campo_4"=>$rqt->campo_4,
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

    public function update_tabla_7(Request $rqt, $id){
        try {
            DB::beginTransaction();
            // return $rqt;
            $tab=Table_7::where('state','A')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
                "table_4_id"=>$rqt->table_4_id,
                "campo_4"=>$rqt->campo_4,
            ])->save();

            DB::commit();
            return response()->json(["Msg"=>"Registro actualizado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    public function delete_tabla_7($id){
        try {
            DB::beginTransaction();
            $tab=Table_7::where('state','A')->find($id);
            if (!$tab) return response()->json(["Error" => "Id ingresado no existe..."]); //  validación
            $tab->fill([
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
