<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'title',
        'comment',
        'is_verified_purchase',
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    protected static function booted(): void
    {
        $refresh = fn (Review $review) => $review->product?->refreshReviewStats();

        static::saved($refresh);
        static::deleted($refresh);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeSorted(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'highest' => $query->orderByDesc('rating')->latest(),
            'lowest' => $query->orderBy('rating')->latest(),
            default => $query->latest(),
        };
    }

    public static function userHasPurchased(User $user, Product $product): bool
    {
        return OrderItem::query()
            ->where('product_id', $product->id)
            ->whereHas('order', fn ($q) => $q->where('user_id', $user->id))
            ->exists();
    }
}
