<?php

use App\Http\Controllers\TesisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('tabla_1_2/get', [TesisController::class,'get_tabla_1_2']);  //table_2 en uso
Route::post('tabla_1_2/create', [TesisController::class,'create_tabla_1_2']);
Route::put('tabla_1_2/update/{id}', [TesisController::class,'update_tabla_1_2']);
Route::delete('tabla_1_2/delete/{id}', [TesisController::class,'delete_tabla_1_2']);

Route::get('tabla_3_4/get', [TesisController::class,'get_tabla_3_4']);
Route::post('tabla_3_4/create', [TesisController::class,'create_tabla_3_4']);
Route::put('tabla_3_4/update/{id}', [TesisController::class,'update_tabla_3_4']);
Route::delete('tabla_3_4/delete/{id}', [TesisController::class,'delete_tabla_3_4']);

Route::get('tabla_5_6/get', [TesisController::class,'get_tabla_5_6']);
Route::post('tabla_5_6/create', [TesisController::class,'create_tabla_5_6']);
Route::put('tabla_5_6/update/{id}', [TesisController::class,'update_tabla_5_6']);
Route::delete('tabla_5_6/delete/{id}', [TesisController::class,'delete_tabla_5_6']);

Route::get('tabla_7/get', [TesisController::class,'get_tabla_7']);
Route::post('tabla_7/create', [TesisController::class,'create_tabla_7']);
Route::put('tabla_7/update/{id}', [TesisController::class,'update_tabla_7']);
Route::delete('tabla_7/delete/{id}', [TesisController::class,'delete_tabla_7']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
