<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComandaProduct extends Model
{
    use HasFactory;

    public function comandas()
    {
        return $this->belongsToMany(Comandas::class, 'comanda_products')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'comanda_products')
            ->withPivot('quantity', 'individual_price')
            ->withTimestamps();
    }
}
