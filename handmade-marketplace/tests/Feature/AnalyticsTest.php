<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\SellerAnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_revenue_stats_calculate_correctly(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $seller->shop()->create(['name' => 'Shop', 'description' => 'D']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createProduct($seller, 40);

        $order = Order::create([
            'user_id' => $buyer->id,
            'total_amount' => 45.99,
            'shipping_amount' => 5.99,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_name' => 'Test',
            'shipping_phone' => '1',
            'shipping_address' => 'A',
            'shipping_city' => 'B',
            'shipping_state' => 'C',
            'shipping_pincode' => '1',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 40,
        ]);

        $stats = SellerAnalyticsService::for($seller->id)->revenueStats();

        $this->assertEquals(80.0, $stats['total']);
    }

    public function test_seller_analytics_page_loads(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $seller->shop()->create(['name' => 'Shop', 'description' => 'D']);

        $this->actingAs($seller)->get(route('seller.analytics.index'))->assertOk();
    }

    public function test_admin_analytics_page_loads(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('admin.analytics.index'))->assertOk();
    }

    public function test_seller_can_export_orders_csv(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $seller->shop()->create(['name' => 'Shop', 'description' => 'D']);

        $response = $this->actingAs($seller)->get(route('seller.exports.orders'));

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
    }

    private function createProduct(User $seller, float $price = 25): Product
    {
        $shop = $seller->shop;
        $category = Category::create(['name' => 'Cat', 'slug' => 'c-'.uniqid(), 'icon' => '🏺']);

        return Product::create([
            'shop_id' => $shop->id,
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'title' => 'Item',
            'slug' => 'item-'.uniqid(),
            'description' => 'Desc',
            'price' => $price,
            'quantity' => 10,
            'stock_status' => 'in_stock',
            'status' => 'published',
        ]);
    }
}
