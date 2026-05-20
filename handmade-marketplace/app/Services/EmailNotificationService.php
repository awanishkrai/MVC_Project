<?php

namespace App\Services;

use App\Mail\TransactionalMail;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{
    public function isEnabled(): bool
    {
        return (bool) config('craftnest.mail_notifications', true)
            && config('mail.default') !== 'log';
    }

    public function sendToUser(
        User $user,
        string $subject,
        string $heading,
        string $body,
        ?string $actionUrl = null,
        ?string $actionLabel = 'View details',
    ): void {
        if (! $this->isEnabled() || ! $user->email) {
            return;
        }

        try {
            Mail::to($user)->send(new TransactionalMail(
                $subject,
                $heading,
                $body,
                $actionUrl,
                $actionLabel,
            ));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function buyerOrderPlaced(Order $order): void
    {
        $order->loadMissing('user');

        $this->sendToUser(
            $order->user,
            'Order placed — '.$order->formattedId(),
            'Your order is confirmed',
            'Thank you for shopping on CraftNest. Your order '.$order->formattedId().' totaling $'.number_format($order->total_amount, 2).' has been placed successfully.',
            route('orders.show', $order),
            'View order'
        );
    }

    public function buyerOrderShipped(Order $order): void
    {
        $order->loadMissing('user');

        $this->sendToUser(
            $order->user,
            'Order shipped — '.$order->formattedId(),
            'Your order is on the way',
            'Great news! Order '.$order->formattedId().' has been shipped and is heading your way.',
            route('orders.show', $order),
            'Track order'
        );
    }

    public function buyerOrderDelivered(Order $order): void
    {
        $order->loadMissing('user');

        $this->sendToUser(
            $order->user,
            'Order delivered — '.$order->formattedId(),
            'Your order has arrived',
            'Order '.$order->formattedId().' has been marked as delivered. We hope you love your handmade finds!',
            route('orders.show', $order),
            'View order'
        );
    }

    public function sellerNewOrder(User $seller, Order $order): void
    {
        $order->loadMissing('user');

        $this->sendToUser(
            $seller,
            'New order — '.$order->formattedId(),
            'You received a new order',
            $order->user->name.' placed order '.$order->formattedId().' which includes your products. Review and fulfill it from your seller panel.',
            route('seller.orders.index'),
            'View seller orders'
        );
    }

    public function sellerNewReview(User $seller, Review $review): void
    {
        $review->loadMissing(['product', 'user']);

        $this->sendToUser(
            $seller,
            'New review on '.$review->product->title,
            'A buyer left a review',
            $review->user->name.' rated "'.$review->product->title.'" '.$review->rating.' out of 5 stars.',
            route('seller.reviews.index'),
            'View reviews'
        );
    }
}
