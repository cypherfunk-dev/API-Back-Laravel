<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Color extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'color_id');
    }
}
