<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private function createPublishedProduct(User $seller): Product
    {
        $shop = $seller->shop()->create(['name' => 'Test Shop', 'description' => 'Test']);
        $category = Category::create(['name' => 'Pottery', 'slug' => 'pottery-'.uniqid(), 'icon' => '🏺']);

        return Product::create([
            'shop_id' => $shop->id,
            'user_id' => $seller->id,
            'category_id' => $category->id,
            'title' => 'Handmade Bowl',
            'slug' => 'handmade-bowl-'.uniqid(),
            'description' => 'A beautiful bowl',
            'price' => 25.00,
            'quantity' => 10,
            'stock_status' => 'in_stock',
            'status' => 'published',
        ]);
    }

    private function markPurchased(User $buyer, Product $product): void
    {
        $order = Order::create([
            'user_id' => $buyer->id,
            'total_amount' => 25.00,
            'shipping_amount' => 5.99,
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'order_status' => 'delivered',
            'shipping_name' => $buyer->name,
            'shipping_phone' => '9800000000',
            'shipping_address' => '123 Street',
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
    }

    public function test_verified_buyer_can_submit_review(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);
        $this->markPurchased($buyer, $product);

        $response = $this->actingAs($buyer)->post(route('reviews.store', $product), [
            'rating' => 5,
            'title' => 'Lovely craft',
            'comment' => 'Absolutely beautiful handmade quality!',
        ]);

        $response->assertRedirect(route('products.show', $product));
        $this->assertDatabaseHas('reviews', ['user_id' => $buyer->id, 'product_id' => $product->id, 'rating' => 5]);
        $product->refresh();
        $this->assertEquals(1, $product->reviews_count);
        $this->assertEquals(5.0, (float) $product->average_rating);
    }

    public function test_cannot_review_without_purchase(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);

        $response = $this->actingAs($buyer)->post(route('reviews.store', $product), [
            'rating' => 4,
            'comment' => 'Trying to review without buying first.',
        ]);

        $response->assertForbidden();
    }

    public function test_seller_cannot_review_own_product(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller);
        $this->markPurchased($seller, $product);

        $response = $this->actingAs($seller)->post(route('reviews.store', $product), [
            'rating' => 5,
            'comment' => 'Reviewing my own product should fail.',
        ]);

        $response->assertForbidden();
    }

    public function test_duplicate_review_is_prevented(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);
        $this->markPurchased($buyer, $product);

        Review::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 4,
            'comment' => 'First review on this product.',
            'is_verified_purchase' => true,
        ]);

        $response = $this->actingAs($buyer)->post(route('reviews.store', $product), [
            'rating' => 5,
            'comment' => 'Second review should not be allowed.',
        ]);

        $response->assertForbidden();
    }

    public function test_buyer_can_update_and_delete_own_review(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);

        $review = Review::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'rating' => 3,
            'comment' => 'Good but could be better overall.',
            'is_verified_purchase' => true,
        ]);

        $this->actingAs($buyer)->put(route('reviews.update', [$product, $review]), [
            'rating' => 5,
            'comment' => 'Updated: absolutely perfect now!',
        ])->assertRedirect(route('products.show', $product));

        $review->refresh();
        $this->assertEquals(5, $review->rating);

        $this->actingAs($buyer)->delete(route('reviews.destroy', [$product, $review]))
            ->assertRedirect(route('products.show', $product));

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
        $product->refresh();
        $this->assertEquals(0, $product->reviews_count);
    }

    public function test_rating_distribution_on_product_page(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller);

        Review::create(['user_id' => User::factory()->create()->id, 'product_id' => $product->id, 'rating' => 5, 'comment' => 'Five star review here.', 'is_verified_purchase' => true]);
        Review::create(['user_id' => User::factory()->create()->id, 'product_id' => $product->id, 'rating' => 4, 'comment' => 'Four star review here.', 'is_verified_purchase' => true]);

        $product->refreshReviewStats();

        $response = $this->get(route('products.show', $product));

        $response->assertOk();
        $response->assertSee('Reviews');
        $response->assertSee('2 reviews');
    }
}
