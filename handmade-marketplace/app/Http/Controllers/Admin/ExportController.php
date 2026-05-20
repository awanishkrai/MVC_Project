<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function orders(): StreamedResponse
    {
        $orders = Order::with('user')->latest()->get();

        return $this->csv('platform-orders.csv', ['Order', 'Buyer', 'Email', 'Total', 'Status', 'Payment', 'Date'], function ($handle) use ($orders) {
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->formattedId(),
                    $order->user->name,
                    $order->user->email,
                    $order->total_amount,
                    $order->order_status,
                    $order->payment_method,
                    $order->created_at->toDateTimeString(),
                ]);
            }
        });
    }

    public function users(): StreamedResponse
    {
        $users = User::latest()->get();

        return $this->csv('platform-users.csv', ['Name', 'Email', 'Role', 'Joined'], function ($handle) use ($users) {
            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at->toDateTimeString(),
                ]);
            }
        });
    }

    public function reviews(): StreamedResponse
    {
        $reviews = Review::with(['user', 'product'])->latest()->get();

        return $this->csv('platform-reviews.csv', ['Product', 'Reviewer', 'Rating', 'Title', 'Comment', 'Date'], function ($handle) use ($reviews) {
            foreach ($reviews as $review) {
                fputcsv($handle, [
                    $review->product->title,
                    $review->user->name,
                    $review->rating,
                    $review->title ?? '',
                    $review->comment,
                    $review->created_at->toDateTimeString(),
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
