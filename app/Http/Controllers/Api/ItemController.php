<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

use OpenApi\Annotations as OA;


class ItemController extends Controller
{
    /**
 * @OA\Get(
 *     path="/items",
 *     summary="Lista todos los items en el inventario",
 *     tags={"Items"},
 *     operationId="getItems",
 *     @OA\Response(response=200, description="Lista de items en el inventario"),
 *     @OA\Response(response=404, description="No se encontraron items"),
 *     @OA\Response(response=500, description="Error interno del servidor"),
 * )
 */
    public function index()
    {
        // Puedes usar paginación si quieres limitar resultados
            $items = Item::with(['inventories.color', 'inventories.size'])->paginate(15);

        return response()->json([
            'data' => $items->items(),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ]
        ]);
    }
/**
 * @OA\Get(
 *     path="/items/{sku}",
 *     summary="Obtiene un item por su SKU",
 *     tags={"Items"},
 *     operationId="getItemBySku",
 *     @OA\Parameter(
 *         name="sku",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         description="SKU del item a buscar"
 *     ),
 *     @OA\Response(response=200, description="Item encontrado"),
 *     @OA\Response(response=404, description="Item no encontrado"),
 *     @OA\Response(response=500, description="Error interno del servidor")
 * )
 */

    public function show($sku)
    {
        $item = Item::with(['inventories.color', 'inventories.size'])
            ->where('sku', $sku)
            ->firstOrFail();

        return response()->json($item);
    }
    /**
     * @OA\Get(
     *     path="/items/{sku}/inventory",
     *     summary="Obtiene el inventario de un item por su SKU",
     *     tags={"Items"},
     *     operationId="getItemInventoryBySku",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item a buscar"
     *     ),
     *     @OA\Response(response=200, description="Inventario encontrado"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function inventory($sku)
    {
        $item = Item::with(['inventories.color', 'inventories.size'])
            ->where('sku', $sku)
            ->firstOrFail();

        return response()->json($item->inventories);
    }
}
