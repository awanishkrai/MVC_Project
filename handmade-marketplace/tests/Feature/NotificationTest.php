<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\CraftNestNotification;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_placed_notifies_buyer_and_sellers(): void
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createProduct($seller);

        $order = $this->createOrder($buyer, $product);

        app(NotificationService::class)->afterOrderPlaced($order);

        Notification::assertSentTo($buyer, CraftNestNotification::class);
        Notification::assertSentTo($seller, CraftNestNotification::class);
        Notification::assertSentTo($admin, CraftNestNotification::class);
    }

    public function test_user_can_mark_notification_as_read(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $buyer->notify(new CraftNestNotification(
            'test',
            'Test alert',
            'This is a test notification.',
            route('home')
        ));

        $notification = $buyer->unreadNotifications->first();
        $this->assertNotNull($notification);

        $response = $this->actingAs($buyer)->get(route('notifications.read', $notification->id));

        $response->assertRedirect(route('home'));
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_notifications_index_requires_auth(): void
    {
        $this->get(route('notifications.index'))->assertRedirect(route('login'));
    }

    public function test_mark_all_as_read(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $buyer->notify(new CraftNestNotification('a', 'A', 'Message A'));
        $buyer->notify(new CraftNestNotification('b', 'B', 'Message B'));

        $this->actingAs($buyer)->post(route('notifications.read-all'))->assertRedirect();

        $this->assertEquals(0, $buyer->fresh()->unreadNotifications()->count());
    }

    private function createProduct(User $seller): Product
    {
        $shop = $seller->shop()->create(['name' => 'Shop', 'description' => 'Desc']);
        $category = Category::create(['name' => 'Art', 'slug' => 'art-'.uniqid(), 'icon' => '🎨']);

        return Product::create([
            'shop_id' => $shop->id,
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'title' => 'Vase',
            'slug' => 'vase-'.uniqid(),
            'description' => 'Handmade vase',
            'price' => 50,
            'quantity' => 5,
            'stock_status' => 'in_stock',
            'status' => 'published',
        ]);
    }

    private function createOrder(User $buyer, Product $product): Order
    {
        $order = Order::create([
            'user_id' => $buyer->id,
            'total_amount' => 55.99,
            'shipping_amount' => 5.99,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_name' => $buyer->name,
            'shipping_phone' => '9800000000',
            'shipping_address' => '123 St',
            'shipping_city' => 'City',
            'shipping_state' => 'State',
            'shipping_pincode' => '44600',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);

        return $order->load(['user', 'items.product.user']);
    }
}
