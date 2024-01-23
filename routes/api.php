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

Route::get('tabla_1/get', [TesisController::class,'get_tabla_1']);
Route::get('tabla_1/create', [TesisController::class,'create_tabla_1']);
Route::get('tabla_1/update', [TesisController::class,'update_tabla_1']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
