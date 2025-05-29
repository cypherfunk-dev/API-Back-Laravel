<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
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
