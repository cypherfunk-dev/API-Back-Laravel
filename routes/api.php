<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\InventoryController;

Route::prefix('v1')->group(function () {
    $itemSkuRoute = '/items/{sku}';
    $itemInventoryRoute = '/items/{sku}/inventory';
    $itemInventoryIdRoute = '/items/{sku}/inventory/{inventory_id}';


    Route::get('/items', [ItemController::class, 'index']);
    Route::get($itemSkuRoute, [ItemController::class, 'show']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::put($itemSkuRoute, [ItemController::class, 'update']);
    Route::delete($itemSkuRoute, [ItemController::class, 'destroy']);

    Route::get($itemInventoryRoute, [InventoryController::class,'index']);
    Route::get($itemInventoryIdRoute, [InventoryController::class,'getInventoryBySkuAndId']);

    Route::post($itemInventoryRoute, [InventoryController::class, 'storeInventory']);
    Route::put($itemInventoryIdRoute, [InventoryController::class, 'updateInventory']);
    Route::delete($itemInventoryIdRoute, [InventoryController::class, 'destroyInventory']);
});
