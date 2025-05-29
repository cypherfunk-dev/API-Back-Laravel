<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        // Fetch all items
        $items = \App\Models\Item::with(['inventories.color', 'inventories.size'])->get();
        return response()->json($items);
    }
    public function show($sku)
    {
        // Fetch a single item by SKU
        $item = \App\Models\Item::with(['inventories.color', 'inventories.size'])
            ->where('sku', $sku)
            ->firstOrFail();
        return response()->json($item);
    }
    public function inventory($sku)
    {
        // Fetch variants of a single item by SKU
        // This method returns the inventories associated with the item, including color and size
        $item = \App\Models\Item::with(['inventories.color', 'inventories.size'])
            ->where('sku', $sku)
            ->firstOrFail();
        return response()->json($item->inventories);
    }
}
