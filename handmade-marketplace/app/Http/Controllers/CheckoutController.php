<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function index(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add products before checkout.');
        }

        return view('public.checkout.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'shipping' => $this->cart->shipping(),
            'total' => $this->cart->total(),
            'user' => auth()->user(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = $this->cart->items();

        try {
            $order = DB::transaction(function () use ($request, $items) {
                foreach ($items as $item) {
                    $product = Product::lockForUpdate()->find($item['product']->id);

                    if (! $product || ! $product->isInStock() || $item['quantity'] > $product->quantity) {
                        throw new \RuntimeException(
                            "{$item['product']->title} is no longer available in the requested quantity."
                        );
                    }
                }

                $subtotal = $this->cart->subtotal();
                $shipping = $this->cart->shipping();
                $paymentMethod = $request->validated('payment_method');

                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'total_amount' => $subtotal + $shipping,
                    'shipping_amount' => $shipping,
                    'payment_method' => $paymentMethod,
                    'payment_status' => $paymentMethod === 'card' ? 'paid' : 'pending',
                    'order_status' => 'pending',
                    'shipping_name' => $request->validated('shipping_name'),
                    'shipping_phone' => $request->validated('shipping_phone'),
                    'shipping_address' => $request->validated('shipping_address'),
                    'shipping_city' => $request->validated('shipping_city'),
                    'shipping_state' => $request->validated('shipping_state'),
                    'shipping_pincode' => $request->validated('shipping_pincode'),
                ]);

                foreach ($items as $item) {
                    $product = Product::lockForUpdate()->find($item['product']->id);

                    $order->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                    ]);

                    $product->quantity -= $item['quantity'];
                    if ($product->quantity <= 0) {
                        $product->quantity = 0;
                        $product->stock_status = 'out_of_stock';
                    } elseif ($product->quantity <= 3) {
                        $product->stock_status = 'low_stock';
                    }
                    $product->save();
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        $this->cart->clear();

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order): View|RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product.shop']);

        return view('public.checkout.success', compact('order'));
    }
}
