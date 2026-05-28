<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    $admin = User::updateOrCreate(
      ['email' => 'admin@craftnest.test'],
      [
        'name' => 'CraftNest Admin',
        'password' => Hash::make('password'),
        'role' => 'admin',
      ]
    );

    $seller = User::updateOrCreate(
      ['email' => 'seller@craftnest.test'],
      [
        'name' => 'Demo Seller',
        'password' => Hash::make('password'),
        'role' => 'seller',
      ]
    );

    $buyer = User::updateOrCreate(
      ['email' => 'buyer@craftnest.test'],
      [
        'name' => 'Demo Buyer',
        'password' => Hash::make('password'),
        'role' => 'buyer',
      ]
    );

    $this->call(CategorySeeder::class);

    // Seed Shop for Seller
    $shop = Shop::firstOrCreate(
      ['user_id' => $seller->id],
      [
        'name' => 'Rustic Handmade Goods',
        'description' => 'We create beautiful, rustic handmade items for your home and lifestyle.',
        'story' => 'Started in 2020 out of a small garage, we have grown to love crafting unique pieces.',
        'location' => 'Portland, OR',
        'policies' => 'No returns on custom items. Standard shipping within 3-5 business days.',
        'is_verified' => true,
      ]
    );

    // Seed Products
    $categories = Category::all();
    if ($categories->isNotEmpty()) {
      $productsData = [
        [
          'title' => 'Handcrafted Wooden Bowl',
          'description' => 'A beautifully carved wooden bowl made from reclaimed oak. Perfect for salads or as a centerpiece.',
          'price' => 45.00,
          'quantity' => 10,
          'handmade_material' => 'Reclaimed Oak Wood',
          'delivery_time' => '3-5 business days',
          'stock_status' => 'in_stock',
          'status' => 'published',
          'is_made_to_order' => false,
        ],
        [
          'title' => 'Knitted Winter Scarf',
          'description' => 'Stay warm with this cozy, hand-knitted scarf made from 100% organic merino wool.',
          'price' => 35.50,
          'quantity' => 20,
          'handmade_material' => 'Organic Merino Wool',
          'delivery_time' => '1-2 weeks',
          'stock_status' => 'in_stock',
          'status' => 'published',
          'is_made_to_order' => true,
        ],
        [
          'title' => 'Ceramic Coffee Mug',
          'description' => 'Start your morning right with this unique, glazed ceramic coffee mug. Microwave and dishwasher safe.',
          'price' => 22.00,
          'quantity' => 15,
          'handmade_material' => 'Ceramic, Glaze',
          'delivery_time' => '3-5 business days',
          'stock_status' => 'in_stock',
          'status' => 'published',
          'is_made_to_order' => false,
        ],
        [
          'title' => 'Leather Minimalist Wallet',
          'description' => 'A slim, hand-stitched leather wallet that holds your essential cards and cash comfortably.',
          'price' => 55.00,
          'quantity' => 5,
          'handmade_material' => 'Full-grain Leather',
          'delivery_time' => '5-7 business days',
          'stock_status' => 'low_stock',
          'status' => 'published',
          'is_made_to_order' => false,
        ]
      ];

      foreach ($productsData as $data) {
        Product::firstOrCreate(
          [
            'shop_id' => $shop->id,
            'title' => $data['title']
          ],
          array_merge($data, [
            'user_id' => $seller->id,
            'category_id' => $categories->random()->id,
            'slug' => Str::slug($data['title']),
          ])
        );
      }
    }

    // Generate lots of Buyers
    $buyers = User::factory(50)->create(['role' => 'buyer']);

    // Generate lots of Sellers, Shops, Products, and Reviews
    User::factory(20)->create(['role' => 'seller'])->each(function ($factorySeller) use ($categories, $buyers) {
        $shop = Shop::factory()->create(['user_id' => $factorySeller->id]);

        Product::factory(random_int(3, 8))->create([
            'user_id' => $factorySeller->id,
            'shop_id' => $shop->id,
            'category_id' => $categories->random()->id,
        ])->each(function ($product) use ($buyers) {
            // Generate 0 to 5 reviews for each product
            $numReviews = random_int(0, 5);
            if ($numReviews > 0) {
                $reviewers = $buyers->random($numReviews);
                foreach ($reviewers as $reviewer) {
                    \App\Models\Review::factory()->create([
                        'user_id' => $reviewer->id,
                        'product_id' => $product->id,
                    ]);
                }
                $product->refreshReviewStats();
            }
        });
    });

  }
}
