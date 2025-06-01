<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\InventoryController;

Route::prefix('v1')->group(function () {
    $itemSkuRoute = '/items/{sku}';
    $itemInventoryRoute = '/items/{sku}/inventory';
    $itemInventoryIdRoute = '/items/{sku}/inventory/{inventory_id}';
    $customItemsThrottle = 'throttle:custom-items';


    Route::middleware($customItemsThrottle)->get('/items', [ItemController::class, 'index']);
    Route::middleware($customItemsThrottle)->get($itemSkuRoute, [ItemController::class, 'show']);
    Route::middleware($customItemsThrottle)->post('/items', [ItemController::class, 'store']);
    Route::middleware($customItemsThrottle)->put($itemSkuRoute, [ItemController::class, 'update']);
    Route::middleware($customItemsThrottle)->delete($itemSkuRoute, [ItemController::class, 'destroy']);

    Route::middleware($customItemsThrottle)->get($itemInventoryRoute, [InventoryController::class,'index']);
    Route::middleware($customItemsThrottle)->get($itemInventoryIdRoute, [InventoryController::class,'getInventoryBySkuAndId']);

    Route::middleware($customItemsThrottle)->get($itemInventoryRoute, [InventoryController::class, 'storeInventory']);
    Route::middleware($customItemsThrottle)->put($itemInventoryIdRoute, [InventoryController::class, 'updateInventory']);
    Route::middleware($customItemsThrottle)->delete($itemInventoryIdRoute, [InventoryController::class, 'destroyInventory']);
});
