<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create categories
        $tech = Category::create([
            'name' => 'Smart Tech',
            'slug' => 'electronics',
            'icon' => '🎧',
            'description' => 'Premium luxury gadgets and acoustic sound drivers.'
        ]);

        $wearables = Category::create([
            'name' => 'Wearables',
            'slug' => 'wearables',
            'icon' => '⌚',
            'description' => 'Fine horological complications and smart timepieces.'
        ]);

        $streetwear = Category::create([
            'name' => 'Streetwear',
            'slug' => 'streetwear',
            'icon' => '👕',
            'description' => 'Premium tailored fabrics and modern fashion statements.'
        ]);

        $travel = Category::create([
            'name' => 'Travel Gear',
            'slug' => 'travel',
            'icon' => '💼',
            'description' => 'Sophisticated and functional travel bags and luggage accessories.'
        ]);

        // 2. Create products
        Product::create([
            'category_id' => $tech->id,
            'name' => 'AeroBuds Pro Max Edition',
            'brand' => 'VELOX LUXURY ACCENTS',
            'price' => 149.00,
            'description' => 'Experience industry-leading ANC technology, refined acoustic driver structures, and luxurious ergonomics tailored for absolute auditory immersion.',
            'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&auto=format&fit=crop',
            'stock' => 18,
            'rating' => 4.9,
            'reviews_count' => 124
        ]);

        Product::create([
            'category_id' => $wearables->id,
            'name' => 'Titan Chrono Watch',
            'brand' => 'Chrono Lab',
            'price' => 299.00,
            'description' => 'Crafted with premium grade-5 titanium, sapphire crystal display, and mechanical automatic complication detailing.',
            'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&auto=format&fit=crop',
            'stock' => 12,
            'rating' => 4.8,
            'reviews_count' => 84
        ]);

        Product::create([
            'category_id' => $travel->id,
            'name' => 'Classic Leather Duffle Bag',
            'brand' => 'Bounty Luxury',
            'price' => 89.00,
            'description' => 'Hand-burnished full grain leather with solid brass accessories, tailored for the sophisticated modern voyager.',
            'img' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=800&auto=format&fit=crop',
            'stock' => 25,
            'rating' => 4.7,
            'reviews_count' => 96
        ]);
        
        Product::create([
            'category_id' => $streetwear->id,
            'name' => 'Pro Running Shoes',
            'brand' => 'Nike Active',
            'price' => 180.00,
            'description' => 'Ergonomic sole design coupled with breathable mesh fabrics for peak performance.',
            'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&auto=format&fit=crop',
            'stock' => 20,
            'rating' => 4.9,
            'reviews_count' => 200
        ]);
    }
}
