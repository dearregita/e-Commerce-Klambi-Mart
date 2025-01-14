<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_sizes_id',
        'name',
        'description',
        'price',
        'category_id',
        'stock_quantity',
        'discount',
        'image',
        'slug',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function product_sizes() {
        return $this->belongsTo(ProductSize::class);
    }
}
