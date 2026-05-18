<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Paintings', 'icon' => '🎨', 'description' => 'Original canvas art, watercolors & prints'],
            ['name' => 'Jewelry', 'icon' => '💎', 'description' => 'Handcrafted rings, necklaces & earrings'],
            ['name' => 'Crochet', 'icon' => '🧶', 'description' => 'Cozy handmade yarn creations'],
            ['name' => 'Pottery', 'icon' => '🏺', 'description' => 'Ceramic bowls, mugs & sculptural pieces'],
            ['name' => 'Home Decor', 'icon' => '🏠', 'description' => 'Artisan pieces for every room'],
            ['name' => 'Handmade Gifts', 'icon' => '🎁', 'description' => 'Unique gifts made with love'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                array_merge($cat, ['slug' => Str::slug($cat['name'])])
            );
        }
    }
}
