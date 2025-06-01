<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;

use OpenApi\Annotations as OA;


class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/items/{sku}/inventory",
     *     summary="Lista el inventario de un item por su SKU",
     *     tags={"Inventories"},
     *     description="Obtiene el inventario de un item especificado por su SKU. Incluye detalles de color, tamaño y precio.",
     *     operationId="getItemInventory",
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
    public function index($sku)
    {
        try {
            $item = Item::where('sku', $sku)
                ->with(['inventories.color', 'inventories.size'])
                ->firstOrFail();

            return response()->json($item);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el inventario'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/items/{sku}/inventory/{inventory_id}",
     *     summary="Obtiene un inventario por ID y SKU del item",
     *     tags={"Inventories"},
     *     operationId="getInventoryBySkuAndId",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item"
     *     ),
     *     @OA\Parameter(
     *         name="inventory_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del inventario"
     *     ),
     *     @OA\Response(response=200, description="Inventario encontrado"),
     *     @OA\Response(response=404, description="Inventario o item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function getInventoryBySkuAndId($sku, $inventory_id)
    {
        try {
            // Buscar el inventario que pertenece al item con ese SKU
            $inventory = Inventory::where('id', $inventory_id)
                ->whereHas('item', function ($query) use ($sku) {
                    $query->where('sku', $sku);
                })
                ->with(['color', 'size'])
                ->firstOrFail();

            return response()->json($inventory, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Inventario o item no encontrado'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/items/{sku}/inventory",
     *     summary="Crea un nuevo inventario para un item",
     *     tags={"Inventories"},
     *     description="Crea un nuevo inventario para un item especificado por su SKU. Requiere color_id, size_id y price.",
     *     operationId="createInventory",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"color_id", "size_id", "price"},
     *             @OA\Property(property="color_id", type="integer", example=1),
     *             @OA\Property(property="size_id", type="integer", example=2),
     *             @OA\Property(property="price", type="integer", example=15000)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Inventario creado"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error al crear el inventario")
     * )
     */
    public function storeInventory(Request $request, $sku)
    {
        $request->validate([
            'color_id' => 'required|integer|exists:colors,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'price' => 'required|integer|min:0',
        ]);

        try {
            $item = Item::where('sku', $sku)->firstOrFail();

            $inventory = $item->inventories()->create([
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'price' => $request->price, // Corregido: antes decía 'quantity'
            ]);

            return response()->json($inventory, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el inventario'], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/items/{sku}/inventory/{inventory_id}",
     *     summary="Actualiza un inventario por ID y SKU del item",
     *     tags={"Inventories"},
     *     operationId="updateInventory",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item"
     *     ),
     *     @OA\Parameter(
     *         name="inventory_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del inventario"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"color_id", "size_id", "price"},
     *             @OA\Property(property="color_id", type="integer", example=1),
     *             @OA\Property(property="size_id", type="integer", example=2),
     *             @OA\Property(property="price", type="number", example=15000.00)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Inventario actualizado"),
     *     @OA\Response(response=404, description="Inventario o item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */

    public function updateInventory(Request $request, $sku, $inventory_id)
    {
        $request->validate([
            'color_id' => 'required|integer|exists:colors,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'price' => 'required|integer|min:0',
        ]);

        try {
            // Buscar el inventario que pertenece al item con ese SKU
            $inventory = Inventory::where('id', $inventory_id)
                ->whereHas('item', function ($query) use ($sku) {
                    $query->where('sku', $sku);
                })
                ->firstOrFail();

            $inventory->update([
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'price' => $request->price,
            ]);

            return response()->json($inventory, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el inventario'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/items/{sku}/inventory/{inventory_id}",
     *     summary="Elimina el inventario de un item por su SKU y su id de inventario",
     *     tags={"Inventories"},
     *     description="Elimina el inventario de un item especificado por su SKU e identificador de tabla. Elimina todas las entradas de inventario asociadas a ese SKU.",
     *     operationId="deleteItemInventoryBySku",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item a eliminar"),
     *     @OA\Parameter(
     *         name="inventory_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID del inventario"
     *     ),
     *     @OA\Response(response=200, description="Inventario eliminado"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     *     @OA\Response(response=204, description="Registro eliminado exitosamente"),
     * )
     */
    public function destroyInventory($sku, $inventory_id)
    {
        try {
            // Buscar el inventario que pertenece al item con ese SKU
            $inventory = Inventory::where('id', $inventory_id)
                ->whereHas('item', function ($query) use ($sku) {
                    $query->where('sku', $sku);
                })
                ->firstOrFail();

            $inventory->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Error al eliminar el inventario'], 500);
        }
    }




}
