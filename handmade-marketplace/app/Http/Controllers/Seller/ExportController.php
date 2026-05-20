<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function orders(): StreamedResponse
    {
        $sellerId = auth()->id();

        $orders = Order::with(['user', 'items.product'])
            ->whereHas('items.product', fn ($q) => $q->where('user_id', $sellerId))
            ->latest()
            ->get();

        return $this->csv('seller-orders.csv', ['Order', 'Buyer', 'Status', 'Your items total', 'Date'], function ($handle) use ($orders, $sellerId) {
            foreach ($orders as $order) {
                $sellerTotal = $order->items
                    ->filter(fn ($item) => $item->product?->user_id === $sellerId)
                    ->sum(fn ($item) => $item->lineTotal());

                fputcsv($handle, [
                    $order->formattedId(),
                    $order->user->name,
                    $order->order_status,
                    number_format($sellerTotal, 2, '.', ''),
                    $order->created_at->toDateTimeString(),
                ]);
            }
        });
    }

    public function products(): StreamedResponse
    {
        $products = auth()->user()->products()->with('category')->latest()->get();

        return $this->csv('seller-products.csv', ['Title', 'Category', 'Price', 'Quantity', 'Stock', 'Status', 'Rating', 'Reviews'], function ($handle) use ($products) {
            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->title,
                    $product->category?->name ?? '',
                    $product->price,
                    $product->quantity,
                    $product->stock_status,
                    $product->status,
                    $product->average_rating ?? '',
                    $product->reviews_count,
                ]);
            }
        });
    }

    /** @param  callable(resource): void  $writer */
    private function csv(string $filename, array $headers, callable $writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $writer) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            $writer($handle);
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
