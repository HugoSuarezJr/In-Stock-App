<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function inStock()
    {
        return $this->stock()->where('in-stock', true)->exists();
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
