<?php

namespace App\Http\Controllers;
/**
 *      @OA\Server(
 *          url="http://localhost:8000/api",
 *          description="Local server"
 *      ),
*       @OA\Info(
 *         title="Todo API",
 *         version="1.0.0",
 *         description="Simple API create todo",
 *     ),
 *     @OA\SecurityScheme(
 *         securityScheme="Bearer",
 *         type="http",
 *         scheme="Bearer",
 *         bearerFormat="JWT"
 *     ),
 */
abstract class Controller
{
    //
}
