<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View
    {
        return view('public.cart.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'shipping' => $this->cart->shipping(),
            'total' => $this->cart->total(),
            'itemCount' => $this->cart->count(),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->status === 'published', 404);

        $quantity = max(1, (int) $request->input('quantity', 1));

        try {
            $this->cart->add($product, $quantity);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $quantity = (int) $request->input('quantity', 1);

        try {
            $this->cart->update($product, $quantity);
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $this->cart->remove($product);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        $this->cart->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
