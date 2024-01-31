<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(title="API Tesis", version="1.0")
*
* @OA\Server(url="http://localhost:8000"),
* @OA\SecurityScheme(
* securityScheme="bearerAuth",
* in="header",
* name="bearerAuth",
* type="http",
* scheme="bearer",
* bearerFormat="JWT")
*/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
