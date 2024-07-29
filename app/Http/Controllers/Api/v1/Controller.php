<?php

namespace App\Http\Controllers\Api\v1;

/**
* @OA\Info(
*     title="Laravel REST API",
*     version="1.0.0",
* )
*
* @OA\Server(
*     url="/api/v1",
*     description="API server"
* )
*
* @OA\SecurityScheme(
*     type="http",
*     securityScheme="bearerAuth",
*     scheme="bearer",
*     bearerFormat="JWT"
* )
*
* @OA\Schema(
*     schema="UnauthenticatedMessage",
*     @OA\Property(property="message", type="string", example="Unauthenticated.")
* )
*/
abstract class Controller
{
    //
}
