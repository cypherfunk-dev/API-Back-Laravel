<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ItemController;

Route::prefix('v1')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{sku}', [ItemController::class, 'show']);
    Route::get('/items/{sku}/inventory', [ItemController::class, 'inventory']);
});
