<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        $items = auth()->user()
            ->wishlists()
            ->with(['product.shop', 'product.category'])
            ->latest()
            ->get()
            ->map(fn ($wishlist) => $wishlist->product)
            ->filter(fn ($product) => $product && $product->status === 'published');

        return view('public.wishlist.index', compact('items'));
    }

    public function store(Product $product): RedirectResponse
    {
        abort_unless($product->status === 'published', 404);

        $this->authorize('add', $product);

        auth()->user()->wishlists()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        $count = $product->wishlists()->count();
        app(NotificationService::class)->notifySellerWishlistMilestone($product, $count);

        return back()->with('success', 'Saved to your wishlist.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('remove', $product);

        auth()->user()->wishlists()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Removed from wishlist.');
    }

    public function moveToCart(Product $product): RedirectResponse
    {
        abort_unless($product->status === 'published', 404);

        $this->authorize('remove', $product);

        if (! $product->isInStock()) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        try {
            $this->cart->add($product, 1);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        auth()->user()->wishlists()->where('product_id', $product->id)->delete();

        return redirect()->route('cart.index')->with('success', 'Moved to cart.');
    }
}
