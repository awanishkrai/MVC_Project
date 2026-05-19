<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class WishlistPolicy
{
    public function add(User $user, Product $product): bool
    {
        return $product->user_id !== $user->id;
    }

    public function remove(User $user, Product $product): bool
    {
        return $product->user_id !== $user->id;
    }
}
