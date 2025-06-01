<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\InventoryController;

Route::prefix('v1')->group(function () {
    define('ITEM_SKU_ROUTE', '/items/{sku}');
    define('ITEM_INVENTORY_ROUTE', '/items/{sku}/inventory');

    Route::get('/items', [ItemController::class, 'index']);
    Route::get(ITEM_SKU_ROUTE, [ItemController::class, 'show']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::put(ITEM_SKU_ROUTE, [ItemController::class, 'update']);
    Route::delete(ITEM_SKU_ROUTE, [ItemController::class, 'destroy']);

    Route::get(ITEM_INVENTORY_ROUTE, [InventoryController::class, 'showInventory']);
    Route::post(ITEM_INVENTORY_ROUTE, [InventoryController::class, 'storeInventory']);
    Route::put(ITEM_INVENTORY_ROUTE, [InventoryController::class, 'updateInventory']);
    Route::delete(ITEM_INVENTORY_ROUTE, [InventoryController::class, 'destroyInventory']);
});
