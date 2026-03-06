<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock_quantity',
        'category'
    ];

    public function scopeInStock($query)
    {
        $query->where('stock_quantity', '>', 0);
    }
}
