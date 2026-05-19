<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'shop_id',
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'quantity',
        'handmade_material',
        'delivery_time',
        'image',
        'stock_status',
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
        'price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title).'-'.Str::random(5);
            }
            if (empty($product->stock_status)) {
                $product->stock_status = $product->quantity > 0 ? 'in_stock' : 'out_of_stock';
            }
        });
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function imageUrl(): ?string
    {
        return PublicStorage::url($this->image);
    }

    public function isInStock(): bool
    {
        return $this->stock_status === 'in_stock' && $this->quantity > 0;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($filters['category'] ?? null, fn ($q, $slug) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->when($filters['stock'] ?? null, fn ($q, $stock) => $q->where('stock_status', $stock))
            ->when($filters['sort'] ?? null, function ($q, $sort) {
                match ($sort) {
                    'price_asc' => $q->orderBy('price'),
                    'price_desc' => $q->orderByDesc('price'),
                    default => $q->latest(),
                };
            }, fn ($q) => $q->latest());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
