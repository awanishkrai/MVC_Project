<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusUpdateRequest;
use App\Models\Order;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $sellerId = auth()->id();

        $orders = Order::with(['user', 'items.product'])
            ->whereHas('items.product', fn ($q) => $q->where('user_id', $sellerId))
            ->latest()
            ->paginate(15);

        return view('seller.orders.index', compact('orders', 'sellerId'));
    }

    public function updateStatus(OrderStatusUpdateRequest $request, Order $order): RedirectResponse
    {
        abort_unless(
            $order->items()->whereHas('product', fn ($q) => $q->where('user_id', auth()->id()))->exists(),
            403
        );

        $previous = $order->order_status;
        $order->update(['order_status' => $request->validated('order_status')]);

        app(NotificationService::class)->afterOrderStatusChanged($order->fresh('user'), $previous);

        return back()->with('success', 'Order status updated.');
    }
}
