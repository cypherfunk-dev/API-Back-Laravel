<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $primaryKey = 'sku';

    protected $fillable = [
        'sku',
        'title',
        'description',
        'status',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'item_id');
    }
}
