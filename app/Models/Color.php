<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $fillable = [
        'name',
        'hex_code',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'color_id');
    }
}
