<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    private function createPublishedProduct(User $seller, int $quantity = 10, string $suffix = ''): Product
    {
        $shop = $seller->shop()->create(['name' => 'Test Shop '.$suffix, 'description' => 'Test']);
        $slug = 'pottery'.($suffix ?: uniqid());
        $category = Category::create(['name' => 'Pottery '.$suffix, 'slug' => $slug, 'icon' => '🏺']);

        return Product::create([
            'shop_id' => $shop->id,
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'title' => 'Handmade Bowl '.$suffix,
            'slug' => 'handmade-bowl-'.($suffix ?: uniqid()),
            'description' => 'A beautiful bowl',
            'price' => 25.00,
            'quantity' => $quantity,
            'stock_status' => 'in_stock',
            'status' => 'published',
        ]);
    }

    public function test_buyer_can_add_product_to_session_cart(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller);

        $response = $this->post(route('cart.add', $product), ['quantity' => 2]);

        $response->assertRedirect();
        $this->assertEquals(2, app(CartService::class)->count());
    }

    public function test_cart_page_shows_items(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller);

        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $response = $this->get(route('cart.index'));

        $response->assertOk();
        $response->assertSee('Handmade Bowl');
    }

    public function test_checkout_requires_auth(): void
    {
        $response = $this->get(route('checkout.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_buyer_can_place_order_with_cod(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller, 5);

        $this->actingAs($buyer)->post(route('cart.add', $product), ['quantity' => 2]);

        $response = $this->actingAs($buyer)->post(route('checkout.store'), [
            'shipping_name' => 'Jane Buyer',
            'shipping_phone' => '9800000000',
            'shipping_address' => '123 Craft Street',
            'shipping_city' => 'Kathmandu',
            'shipping_state' => 'Bagmati',
            'shipping_pincode' => '44600',
            'payment_method' => 'cod',
        ]);

        $order = Order::first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('checkout.success', $order));
        $this->assertDatabaseHas('orders', ['user_id' => $buyer->id, 'payment_method' => 'cod']);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id, 'quantity' => 2]);
        $this->assertEquals(3, $product->fresh()->quantity);
        $this->assertEquals(0, app(CartService::class)->count());
    }

    public function test_seller_sees_orders_with_their_products_only(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $seller = User::factory()->create(['role' => 'seller']);
        $otherSeller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller, 10, 'a');
        $otherProduct = $this->createPublishedProduct($otherSeller, 10, 'b');

        $this->actingAs($buyer)->post(route('cart.add', $product));
        $this->actingAs($buyer)->post(route('cart.add', $otherProduct));
        $this->actingAs($buyer)->post(route('checkout.store'), [
            'shipping_name' => 'Jane Buyer',
            'shipping_phone' => '9800000000',
            'shipping_address' => '123 Craft Street',
            'shipping_city' => 'Kathmandu',
            'shipping_state' => 'Bagmati',
            'shipping_pincode' => '44600',
            'payment_method' => 'cod',
        ]);

        $response = $this->actingAs($seller)->get(route('seller.orders.index'));

        $response->assertOk();
        $response->assertSee('Handmade Bowl a');
        $response->assertSee($buyer->name);
    }

    public function test_cannot_add_more_than_stock(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller, 2);

        $response = $this->post(route('cart.add', $product), ['quantity' => 5]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
