<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use App\Notifications\CraftNestNotification;
use Illuminate\Support\Collection;

class NotificationService
{
    public const LARGE_ORDER_THRESHOLD = 100.00;

    public const LOW_STOCK_PLATFORM_THRESHOLD = 5;

    public const WISHLIST_MILESTONE = 5;

    public function send(User $user, string $type, string $title, string $message, ?string $url = null, array $meta = []): void
    {
        $user->notify(new CraftNestNotification($type, $title, $message, $url, $meta));
    }

    public function notifyAdmins(string $type, string $title, string $message, ?string $url = null, array $meta = []): void
    {
        User::where('role', 'admin')->each(
            fn (User $admin) => $this->send($admin, $type, $title, $message, $url, $meta)
        );
    }

    public function afterOrderPlaced(Order $order): void
    {
        $order->load(['items.product.user']);

        $this->send(
            $order->user,
            'order_placed',
            'Order placed',
            'Your order '.$order->formattedId().' was placed successfully.',
            route('orders.show', $order),
            ['order_id' => $order->id]
        );

        $this->notifySellersNewOrder($order);

        if ((float) $order->total_amount >= self::LARGE_ORDER_THRESHOLD) {
            $this->notifyAdmins(
                'large_order',
                'Large order placed',
                'Order '.$order->formattedId().' totals $'.number_format($order->total_amount, 2).'.',
                route('admin.orders.index'),
                ['order_id' => $order->id]
            );
        }

        $this->notifyAdmins(
            'new_order',
            'New marketplace order',
            'Order '.$order->formattedId().' was placed by '.$order->user->name.'.',
            route('admin.orders.index'),
            ['order_id' => $order->id]
        );

        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && $product->stock_status === 'low_stock') {
                $this->notifySellerLowStock($product);
            }
        }
    }

    public function afterOrderStatusChanged(Order $order, string $previousStatus): void
    {
        $status = $order->order_status;

        if ($status === $previousStatus) {
            return;
        }

        $buyerMessages = [
            'processing' => ['order_confirmed', 'Order confirmed', 'Your order '.$order->formattedId().' is being prepared.'],
            'shipped' => ['order_shipped', 'Order shipped', 'Your order '.$order->formattedId().' is on its way.'],
            'delivered' => ['order_delivered', 'Order delivered', 'Your order '.$order->formattedId().' has been delivered.'],
            'cancelled' => ['order_cancelled', 'Order cancelled', 'Your order '.$order->formattedId().' was cancelled.'],
        ];

        if (isset($buyerMessages[$status])) {
            [$type, $title, $message] = $buyerMessages[$status];
            $this->send($order->user, $type, $title, $message, route('orders.show', $order), ['order_id' => $order->id]);
        }
    }

    public function notifySellersNewOrder(Order $order): void
    {
        $order->loadMissing(['items.product.user', 'user']);

        $this->sellersForOrder($order)->each(function (User $seller) use ($order) {
            $this->send(
                $seller,
                'new_order',
                'New order received',
                'You have items in order '.$order->formattedId().' from '.$order->user->name.'.',
                route('seller.orders.index'),
                ['order_id' => $order->id]
            );
        });
    }

    public function notifySellerNewReview(Review $review): void
    {
        $review->loadMissing(['product.user', 'user']);
        $seller = $review->product?->user;

        if (! $seller) {
            return;
        }

        $this->send(
            $seller,
            'new_review',
            'New product review',
            $review->user->name.' left a '.$review->rating.'★ review on '.$review->product->title.'.',
            route('seller.reviews.index'),
            ['review_id' => $review->id, 'product_id' => $review->product_id]
        );
    }

    public function notifySellerLowStock(Product $product): void
    {
        $product->loadMissing('user');

        if (! $product->user) {
            return;
        }

        $this->send(
            $product->user,
            'low_stock',
            'Low stock alert',
            '"'.$product->title.'" has only '.$product->quantity.' units left.',
            route('seller.products.edit', $product),
            ['product_id' => $product->id]
        );
    }

    public function notifySellerWishlistMilestone(Product $product, int $count): void
    {
        if ($count < self::WISHLIST_MILESTONE || $count % self::WISHLIST_MILESTONE !== 0) {
            return;
        }

        $product->loadMissing('user');

        if (! $product->user) {
            return;
        }

        $this->send(
            $product->user,
            'wishlist_milestone',
            'Wishlist milestone',
            '"'.$product->title.'" was saved by '.$count.' buyers.',
            route('seller.products.edit', $product),
            ['product_id' => $product->id, 'wishlist_count' => $count]
        );
    }

    public function notifyAdminsNewShop(Shop $shop): void
    {
        $shop->loadMissing('user');

        $this->notifyAdmins(
            'new_shop',
            'New seller shop',
            $shop->user->name.' opened "'.$shop->shop_name.'".',
            route('shops.show', $shop),
            ['shop_id' => $shop->id]
        );
    }

    public function notifyAdminsLowStockSummary(int $count): void
    {
        if ($count < self::LOW_STOCK_PLATFORM_THRESHOLD) {
            return;
        }

        $this->notifyAdmins(
            'low_stock_platform',
            'Low stock across marketplace',
            $count.' products are currently low on stock.',
            route('admin.analytics.index'),
            ['count' => $count]
        );
    }

    public function notifyAdminsReviewDeleted(Review $review, User $admin): void
    {
        $review->loadMissing(['product', 'user']);

        $this->notifyAdmins(
            'review_deleted',
            'Review removed by admin',
            $admin->name.' removed a review on "'.$review->product->title.'".',
            route('admin.reviews.index'),
            ['review_id' => $review->id]
        );
    }

    /** @return Collection<int, User> */
    private function sellersForOrder(Order $order): Collection
    {
        return $order->items
            ->map(fn ($item) => $item->product?->user)
            ->filter()
            ->unique('id')
            ->values();
    }
}
