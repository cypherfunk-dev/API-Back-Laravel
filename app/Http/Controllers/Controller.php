<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA; // This line is crucial!

/**
 * @OA\Info(
 * title="API de Inventario",
 * version="1.0.0",
 * description="API para gestionar el inventario de items"
 * )
 *
 * @OA\Server(
 * url="http://127.0.0.1:8000/api/v1",
 * description="Servidor local"
 * )
 *
 * @OA\Tag(
 * name="Items",
 * description="Operaciones relacionadas con los items del inventario"
 * )
 */
abstract class Controller
{
    //
}