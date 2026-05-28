<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(3, true);
        return [
            'shop_id' => Shop::factory(),
            'user_id' => User::factory(),
            'category_id' => 1,
            'title' => ucwords($title),
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 5, 250),
            'quantity' => fake()->numberBetween(0, 50),
            'handmade_material' => fake()->randomElement(['Wood', 'Ceramic', 'Wool', 'Cotton', 'Leather', 'Silver']),
            'delivery_time' => fake()->randomElement(['3-5 days', '1-2 weeks', 'Ships next day']),
            'stock_status' => 'in_stock',
            'is_made_to_order' => fake()->boolean(20),
            'status' => 'published',
        ];
    }
}
