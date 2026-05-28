<?php

namespace App\Models;

use App\Support\PublicStorage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'name',
        'description',
        'banner_url',
        'logo_url',
        'story',
        'location',
        'policies',
        'is_verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /** shop_name maps to the name column (syllabus-friendly label). */
    protected function shopName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attributes['name'] ?? null,
            set: fn (string $value) => ['name' => $value],
        );
    }

    /** Public URL for the shop logo. */
    public function logoUrl(): ?string
    {
        return PublicStorage::url($this->logo_url);
    }

    /** Route key for public shop page. */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
