<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'size_id');
    }
}
