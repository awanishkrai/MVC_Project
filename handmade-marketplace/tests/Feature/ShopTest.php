<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_create_shop(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);

        $response = $this->actingAs($seller)->post(route('shop.store'), [
            'shop_name' => 'Artisan Crafts',
            'description' => 'Handmade pottery and decor',
            'location' => 'Kathmandu',
        ]);

        $response->assertRedirect(route('shop.dashboard'));
        $this->assertDatabaseHas('shops', [
            'user_id' => $seller->id,
            'name' => 'Artisan Crafts',
        ]);
    }

    public function test_public_can_view_shop_page(): void
    {
        $seller = User::factory()->create(['role' => 'seller']);
        $shop = $seller->shop()->create([
            'name' => 'Test Shop',
            'description' => 'A lovely shop',
        ]);

        $response = $this->get(route('shops.show', $shop));

        $response->assertOk();
        $response->assertSee('Test Shop');
    }

    public function test_buyer_cannot_access_shop_dashboard(): void
    {
        $buyer = User::factory()->create(['role' => 'buyer']);

        $response = $this->actingAs($buyer)->get(route('shop.dashboard'));

        $response->assertRedirect(route('buyer.home'));
    }
}
