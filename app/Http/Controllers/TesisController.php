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

    /**
     * Permite visualizar un listado de todos los registros
     * @OA\Get (
     *     path="/api/tabla_1_2/get",
     *     summary="Muestra los Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 1 - 2"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="campo_1", type="string", example="Nombre Example"),
     *              @OA\Property(property="campo_2", type="string", example="Apellido Example"),
     *              @OA\Property(property="campo_3", type="string", example="Empresa Example SAC"),
     *              @OA\Property(property="state", type="char", example="A"),
     *              @OA\Property(type="array", property="table_2",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="campo_1", type="integer", example="+51 975616231"),
     *                      @OA\Property(property="table_1_id", type="integer", example=1),
     *                      @OA\Property(property="state", type="char", example="A"),
     *                  )
     *              )
     *          )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se encuentran los datos")
     *             )
     *         )
     *  )
     */

    public function get_tabla_1_2(){
        $variable=Table_1::where('state','A')->with('table_2')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    /**
     * Crear nuevos Registros para Table 1 y 2
     * @OA\Post(
     *     path="/api/tabla_1_2/create",
     *     summary="Crea Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 1 - 2"},
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(property="campo_1", type="string"),
     *                  @OA\Property(property="campo_2", type="string"),
     *                  @OA\Property(property="campo_3", type="string"),
     *
     *                  @OA\Property(property="table_2", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="campo_1", type="string"),
     *                      )
     *                  ),
     *
     *                  example={
     *                      "campo_1": "Nombre Example 3",
     *                      "campo_2": "Apellido Example 3",
     *                      "campo_3": "Empresa Example SAC 3",
     *                      "table_2":{
     *                          {
     *                              "campo_1": "987212211",
     *                          },
     *                          {
     *                              "campo_1": "978131212",
     *                          }
     *                      }
     *                   }
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Error: El Registro no se ha creado"),
     *         )
     *     ),
     * )
     */

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

    /**
     * Actualiza un Registro de Table 1 y 2 mediante su ID
     *
     * @OA\Put(
     *     path="/api/tabla_1_2/update/{id}",
     *     summary="Actualiza Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 1 - 2"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *          @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(description="Descripcion del campo 1",@OA\Schema(type="string"), name="campo_1", in="query", required=false, example="Nombre Example 3"),
     *      @OA\Parameter(description="Descripcion del campo 2",@OA\Schema(type="string"), name="campo_2", in="query", required=false, example="Apellido Example 3"),
     *      @OA\Parameter(description="Descripcion del campo 3",@OA\Schema(type="string"), name="campo_3", in="query", required=false, example="Empresa Example SAC 3"),
     *      @OA\Parameter(description="Descripcion del campo 1 de la tabla 2",@OA\Schema(type="string"), name="campo_1", in="query", required=false, example="987212211"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(property="campo_1", type="string"),
     *                  @OA\Property(property="campo_2", type="string"),
     *                  @OA\Property(property="campo_3", type="string"),
     *
     *                  @OA\Property(property="table_2", type="array",
     *                      @OA\Items(type="object",
     *                          @OA\Property(property="campo_1", type="integer"),
     *                      )
     *                  ),
     *
     *                  example={
     *                      "campo_1": "Nombre Example 3",
     *                      "campo_2": "Apellido Example 3",
     *                      "campo_3": "Empresa Example SAC 3",
     *                      "table_2":{
     *                          {
     *                              "campo_1": "987212211",
     *                          },
     *                          {
     *                              "campo_1": "978131212",
     *                          }
     *                      }
     *                   }
     *              )
     *          )
     *      ),
     *         @OA\Response(response=200,description="success",
     *             @OA\JsonContent(
     *                 @OA\Property(property="resp", type="string", example="Registro actualizado correctamente")
     *             )
     *      ),
     *         @OA\Response(response=501,description="invalid",
     *             @OA\JsonContent(
     *                 @OA\Property(property="error", type="string", example="error: Registro no actualizado...")
     *             )
     *         )
     *     )
     */

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

    /**
     * Inactiva Registros de Table 1 y 2
     * @OA\Delete (
     *     path="/api/tabla_1_2/delete/{id}",
     *     summary = "Inactiva Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 1 - 2"},
     *     @OA\Parameter(
     *        in="path",
     *        name="id",
     *        required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro inactivado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El registro no se ha inactivado"),
     *          )
     *      ),
     *  )
     */

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

    //================= table 3 y 4 =============================================================\\

    /**
     * Permite visualizar un listado de todos los registros
     * @OA\Get (
     *     path="/api/tabla_3_4/get",
     *     summary="Muestra los Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 3 - 4"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="campo_1", type="string", example="Nombre Example"),
     *              @OA\Property(property="state", type="char", example="A"),
     *          )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se encuentran los datos")
     *             )
     *         )
     *  )
     */

    public function get_tabla_3_4(){
        $variable=Table_3_4::where('state','A')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    /**
     * Crear nuevos Registros para Table 3 o 4
     * @OA\Post(
     *     path="/api/tabla_3_4/create",
     *     summary="Crea Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 3 - 4"},
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(property="campo_1", type="string", example="unidad/presentacion example 1"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Error: El Registro no se ha creado"),
     *         )
     *     ),
     * )
     */

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

    /**
     * Actualiza un Registro de Table 3 o 4 mediante su ID
     *
     * @OA\Put(
     *     path="/api/tabla_3_4/update/{id}",
     *     summary="Actualiza Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 3 - 4"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *          @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(description="Descripcion del campo 1",@OA\Schema(type="string"), name="campo_1", in="query", required=false, example="unidad/presentacion example 1"),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(property="campo_1", type="string", example="unidad/presentacion example 1"),
     *              )
     *          )
     *      ),
     *         @OA\Response(response=200,description="success",
     *             @OA\JsonContent(
     *                 @OA\Property(property="resp", type="string", example="Registro actualizado correctamente")
     *             )
     *      ),
     *         @OA\Response(response=501,description="invalid",
     *             @OA\JsonContent(
     *                 @OA\Property(property="error", type="string", example="error: Registro no actualizado...")
     *             )
     *         )
     *     )
     */

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

    /**
     * Inactiva Registros de Table 3 o 4
     * @OA\Delete (
     *     path="/api/tabla_3_4/delete/{id}",
     *     summary = "Inactiva Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 3 - 4"},
     *     @OA\Parameter(
     *        in="path",
     *        name="id",
     *        required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro inactivado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El registro no se ha inactivado"),
     *         )
     *     )
     * )
     */

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

    //================= table 5 y 6 =============================================================\\

    /**
     * Permite visualizar un listado de todos los registros
     * @OA\Get (
     *     path="/api/tabla_5_6/get",
     *     summary="Muestra los Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 5 - 6"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="campo_1", type="string", example="Nombre Example"),
     *              @OA\Property(property="campo_2", type="string", example="Apellido Example"),
     *              @OA\Property(property="table_3_id", type="integer", example=2),
     *              @OA\Property(property="state", type="char", example="A"),
     *              @OA\Property(type="array", property="table_3",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(property="campo_1", type="integer", example="unidad example 1"),
     *                      @OA\Property(property="state", type="char", example="A"),
     *                  )
     *              )
     *          )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se encuentran los datos")
     *             )
     *         )
     *  )
     */

    public function get_tabla_5_6(){
        $variable=Table_5_6::where('state','A')->with('table_3')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    /**
     * Crear nuevos Registros para Table 5 y 6
     * @OA\Post(
     *     path="/api/tabla_5_6/create",
     *     summary="Crea Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 5 - 6"},
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="aplication/json",
     *             @OA\Schema(
     *                 @OA\Property(property="campo_1", type="string", example="servicio example 1"),
     *                 @OA\Property(property="campo_2", type="string", example="descripcion example 1"),
     *                 @OA\Property(property="table_3_id", type="integer", example=1),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Error: El Registro no se ha creado"),
     *         )
     *     ),
     * )
     */

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

    /**
     * Actualiza un Registro de Table 5 o 6 mediante su ID
     *
     * @OA\Put(
     *     path="/api/tabla_5_6/update/{id}",
     *     summary="Actualiza Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 5 - 6"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *          @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(description="Descripcion del campo 1",@OA\Schema(type="string"), name="campo_1", in="query", required=false, example="servicio example 1"),
     *      @OA\Parameter(description="Descripcion del campo 2",@OA\Schema(type="string"), name="campo_2", in="query", required=false, example="descripcion example 1"),
     *      @OA\Parameter(description="el ID de la tabla_3_4",@OA\Schema(type="integer"), name="table_3_id", in="query", required=false, example=1),
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="aplication/json",
     *              @OA\Schema(
     *                  @OA\Property(property="campo_1", type="string", example="servicio example 1"),
     *                 @OA\Property(property="campo_2", type="string", example="descripcion example 1"),
     *                 @OA\Property(property="table_3_id", type="integer", example=1),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Registro actualizado correctamente")
     *          )
     *      ),
     *      @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="error: Registro no actualizado...")
     *          )
     *      )
     *  )
     */

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

    /**
     * Inactiva Registros de Table 5 o 6
     * @OA\Delete (
     *     path="/api/tabla_5_6/delete/{id}",
     *     summary = "Inactiva Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 5 - 6"},
     *     @OA\Parameter(
     *        in="path",
     *        name="id",
     *        required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro inactivado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El registro no se ha inactivado"),
     *         )
     *     )
     * )
     */

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

    //================= table 7 =============================================================\\

    /**
     * Permite visualizar un listado de todos los registros
     * @OA\Get (
     *     path="/api/tabla_7/get",
     *     summary="Muestra los Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 7"},
     *     @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="campo_1", type="string", example="Materia Prima Example"),
     *              @OA\Property(property="campo_2", type="string", example="Descripcion Example"),
     *              @OA\Property(property="campo_3", type="string", example="Codigo Example"),
     *              @OA\Property(property="table_4_id", type="integer", example=2),
     *              @OA\Property(property="campo_4", type="string", example=30),
     *              @OA\Property(property="state", type="char", example="A"),
     *              @OA\Property(type="array", property="table_4",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=2),
     *                      @OA\Property(property="campo_1", type="integer", example="presentacion example 1"),
     *                      @OA\Property(property="state", type="char", example="A"),
     *                  )
     *              )
     *          )
     *      ),
     *         @OA\Response(response=400,description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No se encuentran los datos")
     *             )
     *         )
     *  )
     */

    public function get_tabla_7(){
        $variable=Table_7::where('state','A')->with('table_4')->get();
        if(count($variable)==0) return response()->json(["Error" => "No hay Registros..."]);
        return response()->json($variable);
    }

    /**
     * Crear nuevos Registros para Table 7
     * @OA\Post(
     *     path="/api/tabla_7/create",
     *     summary="Crea Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 7"},
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="aplication/json",
     *             @OA\Schema(
     *                 @OA\Property(property="campo_1", type="string", example="Materia Prima Example"),
     *                 @OA\Property(property="campo_2", type="string", example="Descripcion Example"),
     *                 @OA\Property(property="campo_3", type="string", example="Codigo Example"),
     *                 @OA\Property(property="table_4_id", type="integer", example=2),
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro creado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400, description="invalid",
     *         @OA\JsonContent(
     *             @OA\Property(property="Error", type="string", example="Error: El Registro no se ha creado"),
     *         )
     *     ),
     * )
     */

    public function create_tabla_7(Request $rqt){
        try {
            DB::beginTransaction();
            Table_7::updateOrCreate([ //  Materia Prima
                "campo_1"=>$rqt->campo_1,
                "campo_2"=>$rqt->campo_2,
                "campo_3"=>$rqt->campo_3,
            ],[
                "table_4_id"=>$rqt->table_4_id,
                // "campo_4"=>$rqt->campo_4,
                "state"=>"A"
            ]);

            DB::commit();
            return response()->json(["Msg"=>"Registro creado"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["Error".$e]);
        }
    }

    /**
     * Actualiza un Registro de Table 7 mediante su ID
     *
     * @OA\Put(
     *     path="/api/tabla_7/update/{id}",
     *     summary="Actualiza Registros",
     *     security={{ "bearerAuth":{} }},
     *     tags={"Table 7"},
     *     @OA\Parameter(in="path",name="id",required=true,
     *          @OA\Schema(type="string")
     *     ),
     *      @OA\Parameter(description="Descripcion del campo 1",@OA\Schema(type="string"), name="campo_1", in="query", required=false, example="materia prima example 1"),
     *      @OA\Parameter(description="Descripcion del campo 2",@OA\Schema(type="string"), name="campo_2", in="query", required=false, example="descripcion example 1"),
     *      @OA\Parameter(description="Descripcion del campo 3",@OA\Schema(type="string"), name="campo_3", in="query", required=false, example="codigo example 1"),
     *      @OA\Parameter(description="el ID de la tabla_3_4",@OA\Schema(type="integer"), name="table_3_id", in="query", required=false, example=1),
     *      @OA\Parameter(description="Descripcion del campo 4 - numerico",@OA\Schema(type="integer"), name="campo_4", in="query", required=false, example=30),
     *      @OA\RequestBody(
     *         @OA\MediaType(mediaType="aplication/json",
     *             @OA\Schema(
     *                 @OA\Property(property="campo_1", type="string", example="Materia Prima Example"),
     *                 @OA\Property(property="campo_2", type="string", example="Descripcion Example"),
     *                 @OA\Property(property="campo_3", type="string", example="Codigo Example"),
     *                 @OA\Property(property="table_4_id", type="integer", example=2),
     *                 @OA\Property(property="campo_4", type="string", example=30),
     *             )
     *         )
     *     ),
     *      @OA\Response(response=200,description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="resp", type="string", example="Registro actualizado correctamente")
     *          )
     *      ),
     *      @OA\Response(response=501,description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="error: Registro no actualizado...")
     *          )
     *      )
     *  )
     */

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

    /**
     * Inactiva Registros de Table 7
     * @OA\Delete (
     *     path="/api/tabla_7/delete/{id}",
     *     summary = "Inactiva Registros",
     *     security={{ "bearerAuth": {} }},
     *     tags={"Table 7"},
     *     @OA\Parameter(
     *        in="path",
     *        name="id",
     *        required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200,description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="resp", type="string", example="Registro inactivado correctamente")
     *         )
     *     ),
     *     @OA\Response(response=400,description="invalid",
     *          @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Error: El registro no se ha inactivado"),
     *         )
     *     )
     * )
     */

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
