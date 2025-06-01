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
    public function showinventory($sku)
    {
        /*
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
        // Busca el item por SKU y carga las relaciones de inventario, color y tamaño
        try {
            $item = Item::with(['inventories.color', 'inventories.size'])
                ->where('sku', $sku)
                ->firstOrFail();
            return response()->json($item->inventories);
        }
        catch (\Exception $e) {
            // Si no se encuentra el item, lanza una excepción
            return response()->json(['error' => 'Item no encontrado'], 404);
        }

    }
    /**
     * @OA\Post(
     *     path="/items/{sku}/inventory",
     *     summary="Crea un nuevo inventario para un item",
     *     tags={"Items"},
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
     *     path="/items/{sku}/inventory",
     *     summary="Actualiza el inventario de un item por su SKU",
     *     tags={"Items"},
     *     operationId="updateItemInventoryBySku",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item a actualizar"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="color_id", type="integer", description="ID del color del inventario"),
     *             @OA\Property(property="size_id", type="integer", description="ID del tamaño del inventario"),
     *             @OA\Property(property="quantity", type="integer", description="Cantidad del inventario")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Inventario actualizado"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function updateInventory(Request $request, $sku)
    {
        $request->validate([
            'color_id' => 'required|integer|exists:colors,id',
            'size_id' => 'required|integer|exists:sizes,id',
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            // Busca el item por SKU
            $item = Item::where('sku', $sku)->firstOrFail();

            // Actualiza o crea el inventario del item
            $inventory = $item->inventories()->updateOrCreate(
                ['color_id' => $request->color_id, 'size_id' => $request->size_id],
                ['quantity' => $request->quantity]
            );

            return response()->json($inventory, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el inventario'], 500);
        }
    }
    /**
     * @OA\Delete(
     *     path="/items/{sku}/inventory",
     *     summary="Elimina el inventario de un item por su SKU",
     *     tags={"Items"},
     *     operationId="deleteItemInventoryBySku",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item a eliminar"
     *     ),
     *     @OA\Response(response=200, description="Inventario eliminado"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroyInventory($sku)
    {
        try {
            // Busca el item por SKU
            $item = Item::where('sku', $sku)->firstOrFail();

            // Elimina el inventario del item
            $item->inventories()->delete();

            return response()->json(['message' => 'Inventario eliminado'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el inventario'], 500);
        }
    }
}
