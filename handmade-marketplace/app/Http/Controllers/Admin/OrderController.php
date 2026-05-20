<?php

namespace App\Http\Controllers\Admin;

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
        $orders = Order::with(['user', 'items.product.shop'])
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(OrderStatusUpdateRequest $request, Order $order): RedirectResponse
    {
        $previous = $order->order_status;
        $order->update(['order_status' => $request->validated('order_status')]);

        app(NotificationService::class)->afterOrderStatusChanged($order->fresh('user'), $previous);

        return back()->with('success', 'Order status updated.');
    }
}
