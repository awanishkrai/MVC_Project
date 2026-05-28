<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company() . ' ' . fake()->randomElement(['Crafts', 'Studio', 'Handmade', 'Goods', 'Creations']),
            'description' => fake()->paragraph(),
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'policies' => 'No returns on custom items. Standard shipping applies.',
            'is_verified' => fake()->boolean(80),
        ];
    }
}
