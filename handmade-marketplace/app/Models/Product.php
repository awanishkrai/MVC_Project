<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shop_id',
        'title',
        'description',
        'price',
        'quantity',
        'category',
        'is_made_to_order',
        'status',
        'tags',
        'materials',
        'dimensions',
        'shipping_info',
        'return_policy',
    ];

    protected $casts = [
        'tags' => 'json',
        'is_made_to_order' => 'boolean',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
