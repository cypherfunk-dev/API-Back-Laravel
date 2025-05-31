<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Item",
 *     required={"sku", "title", "status"},
 *     @OA\Property(property="sku", type="string", example="SKU1234"),
 *     @OA\Property(property="title", type="string", example="Zapato Deportivo"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Zapato para correr"),
 *     @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active")
 * )
 */

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
        try {
            // Obtiene todos los items con sus relaciones de inventario, color y tamaño
            $items = Item::with(['inventories.color', 'inventories.size'])->get();
            if ($items->isEmpty()) {
                return response()->json(['message' => 'No se encontraron items'], 404);
            }
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => 'Error al obtener los items'], 500);
        }

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
        try {
            // Busca el item por SKU y carga las relaciones de inventario, color y tamaño
            $item = Item::with(['inventories.color', 'inventories.size'])
                ->where('sku', $sku)
                ->firstOrFail();
            return response()->json($item);
        } catch (\Exception $e) {
            // Si no se encuentra el item, lanza una excepción
            return response()->json(['error' => 'Item no encontrado'], 404);
        }
    }
    /**
     * @OA\Post(
     *     path="/items",
     *     summary="Crea un nuevo item",
     *     tags={"Items"},
     *     operationId="createItem",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(response=201, description="Item creado exitosamente"),
     *     @OA\Response(response=400, description="Solicitud inválida"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|string|max:255|unique:items,sku',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $item = Item::create($request->all());
            return response()->json($item, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el item'], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/items/{sku}",
     *     summary="Actualiza un item por su SKU",
     *     tags={"Items"},
     *     operationId="updateItem",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item a actualizar"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Item")
     *     ),
     *     @OA\Response(response=200, description="Item actualizado exitosamente"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function update(Request $request, $sku)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $item = Item::where('sku', $sku)->firstOrFail();
            $item->update($request->all());
            return response()->json($item);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el item'], 500);
        }
    }
    /**
     * @OA\Delete(
     *     path="/items/{sku}",
     *     summary="Elimina un item por su SKU",
     *     tags={"Items"},
     *     operationId="deleteItem",
     *     @OA\Parameter(
     *         name="sku",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="SKU del item a eliminar"
     *     ),
     *     @OA\Response(response=204, description="Item eliminado exitosamente"),
     *     @OA\Response(response=404, description="Item no encontrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function destroy($sku)
    {
        try {
            $item = Item::where('sku', $sku)->firstOrFail();
            $item->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el item'], 500);
        }
    }
}