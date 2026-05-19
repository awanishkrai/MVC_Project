<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function create(User $user, Product $product): bool
    {
        if ($product->user_id === $user->id) {
            return false;
        }

        if ($product->reviews()->where('user_id', $user->id)->exists()) {
            return false;
        }

        return Review::userHasPurchased($user, $product);
    }

    public function update(User $user, Review $review): bool
    {
        return $review->user_id === $user->id;
    }

    public function delete(User $user, Review $review): bool
    {
        return $review->user_id === $user->id || $user->isAdmin();
    }
}
