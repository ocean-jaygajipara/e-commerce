<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'price',
        'description',
        'img',
        'stock',
        'rating',
        'reviews_count',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
