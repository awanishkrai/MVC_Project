<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
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

    public function test_buyer_can_add_and_remove_wishlist(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);

        $this->actingAs($buyer)->post(route('wishlist.store', $product))
            ->assertRedirect();

        $this->assertDatabaseHas('wishlists', ['user_id' => $buyer->id, 'product_id' => $product->id]);

        $this->actingAs($buyer)->delete(route('wishlist.destroy', $product))
            ->assertRedirect();

        $this->assertDatabaseMissing('wishlists', ['user_id' => $buyer->id, 'product_id' => $product->id]);
    }

    public function test_duplicate_wishlist_is_prevented(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $this->actingAs($buyer)->post(route('wishlist.store', $product));

        $this->assertEquals(1, Wishlist::where('user_id', $buyer->id)->where('product_id', $product->id)->count());
    }

    public function test_seller_cannot_wishlist_own_product(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $product = $this->createPublishedProduct($seller);

        $this->actingAs($seller)->post(route('wishlist.store', $product))
            ->assertForbidden();
    }

    public function test_wishlist_persists_for_user(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);

        $this->actingAs($buyer)->post(route('wishlist.store', $product));

        $this->actingAs($buyer)->get(route('wishlist.index'))
            ->assertOk()
            ->assertSee('Handmade Bowl');
    }

    public function test_move_wishlist_item_to_cart(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $buyer = User::factory()->create(['role' => 'buyer']);
        $product = $this->createPublishedProduct($seller);

        Wishlist::create(['user_id' => $buyer->id, 'product_id' => $product->id]);

        $response = $this->actingAs($buyer)->post(route('wishlist.move-to-cart', $product));

        $response->assertRedirect(route('cart.index'));
        $this->assertDatabaseMissing('wishlists', ['user_id' => $buyer->id, 'product_id' => $product->id]);
        $this->assertEquals(1, app(CartService::class)->count());
    }
}
