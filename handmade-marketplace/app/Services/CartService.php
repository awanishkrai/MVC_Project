<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart';

    /** @return array<int, int> product_id => quantity */
    public function all(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return array_sum($this->all());
    }

    public function isEmpty(): bool
    {
        return empty($this->all());
    }

    /** @return Collection<int, array{product: Product, quantity: int, line_total: float}> */
    public function items(): Collection
    {
        $cart = $this->all();

        if (empty($cart)) {
            return collect();
        }

        $products = Product::with(['shop', 'category'])
            ->published()
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return collect($cart)->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);

            if (! $product) {
                return null;
            }

            return [
                'product' => $product,
                'quantity' => (int) $quantity,
                'line_total' => (float) ($product->price * $quantity),
            ];
        })->filter()->values();
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('line_total');
    }

    public function shipping(): float
    {
        return $this->isEmpty() ? 0.0 : 5.99;
    }

    public function total(): float
    {
        return $this->subtotal() + $this->shipping();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $desired = $this->quantity($product->id) + $quantity;
        $this->validateQuantity($product, $desired);

        $cart = $this->all();
        $cart[$product->id] = $desired;
        session([self::SESSION_KEY => $cart]);
    }

    public function update(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->remove($product);

            return;
        }

        $this->validateQuantity($product, $quantity);

        $cart = $this->all();
        $cart[$product->id] = $quantity;
        session([self::SESSION_KEY => $cart]);
    }

    public function remove(Product $product): void
    {
        $cart = $this->all();
        unset($cart[$product->id]);
        session([self::SESSION_KEY => $cart]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function quantity(int $productId): int
    {
        return (int) ($this->all()[$productId] ?? 0);
    }

    private function validateQuantity(Product $product, int $quantity): void
    {
        if (! $product->isInStock()) {
            throw new \InvalidArgumentException('This product is out of stock.');
        }

        if ($quantity > $product->quantity) {
            throw new \InvalidArgumentException("Only {$product->quantity} available in stock.");
        }
    }
}
