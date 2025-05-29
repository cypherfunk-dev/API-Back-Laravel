<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
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

    public function show($sku)
    {
        $item = Item::with(['inventories.color', 'inventories.size'])
            ->where('sku', $sku)
            ->firstOrFail();

        return response()->json($item);
    }

    public function inventory($sku)
    {
        $item = Item::with(['inventories.color', 'inventories.size'])
            ->where('sku', $sku)
            ->firstOrFail();

        return response()->json($item->inventories);
    }
}