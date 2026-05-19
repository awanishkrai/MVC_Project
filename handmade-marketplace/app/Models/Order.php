<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_pincode',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function subtotal(): float
    {
        return (float) $this->items->sum(fn ($item) => $item->price * $item->quantity);
    }

    public function formattedId(): string
    {
        return '#CN-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }
}
