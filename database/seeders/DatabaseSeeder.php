<?php
 
namespace Database\Seeders;
 
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key constraints to safely truncate
        Schema::disableForeignKeyConstraints();
        \App\Models\Order::truncate();
        Category::truncate();
        Product::truncate();
        Schema::enableForeignKeyConstraints();
 
        // Create default test user
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password')
            ]
        );
 
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

        // 2. Create brand new trading products
        // Smart Tech
        Product::create([
            'category_id' => $tech->id,
            'name' => 'SonicWave ANC Headphones',
            'slug' => 'sonicwave-anc-headphones',
            'brand' => 'AeroSound',
            'price' => 14999.00,
            'description' => 'Experience industry-leading ANC noise cancellation, hybrid acoustic sound drivers, and plush memory foam leather cups.',
            'img' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=800',
            'stock' => 15,
            'rating' => 4.9,
            'reviews_count' => 142
        ]);
        Product::create([
            'category_id' => $tech->id,
            'name' => 'UltraSlim 4K Smart Projector',
            'slug' => 'ultraslim-4k-smart-projector',
            'brand' => 'CinemaMax',
            'price' => 24999.00,
            'description' => 'A pocket-sized powerhouse delivering stunning HDR10 visuals, integrated smart TV app ecosystem, and Dolby Atmos audio support.',
            'img' => 'https://images.unsplash.com/photo-1535016120720-40c646be5580?w=800',
            'stock' => 8,
            'rating' => 4.7,
            'reviews_count' => 56
        ]);

        // Wearables
        Product::create([
            'category_id' => $wearables->id,
            'name' => 'Chrono Legacy Automatic Watch',
            'slug' => 'chrono-legacy-automatic-watch',
            'brand' => 'Velox Chrono',
            'price' => 34999.00,
            'description' => 'Featuring grade-5 titanium architecture, scratch-resistant sapphire crystal glass face, and mechanical automatic complication detailing.',
            'img' => 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=800',
            'stock' => 10,
            'rating' => 4.8,
            'reviews_count' => 95
        ]);
        Product::create([
            'category_id' => $wearables->id,
            'name' => 'FitPulse Smart Band v2',
            'slug' => 'fitpulse-smart-band-v2',
            'brand' => 'FitPulse',
            'price' => 4999.00,
            'description' => 'AMOLED touchscreen display with continuous heart rate tracker, advanced blood oxygen sensor, and up to 14 days of active battery life.',
            'img' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=800',
            'stock' => 30,
            'rating' => 4.6,
            'reviews_count' => 210
        ]);

        // Streetwear
        Product::create([
            'category_id' => $streetwear->id,
            'name' => 'Retro Vintage Oversized Hoodie',
            'slug' => 'retro-vintage-oversized-hoodie',
            'brand' => 'HypeThread',
            'price' => 2999.00,
            'description' => 'Heavyweight 450GSM French terry cotton fabric, offering the ultimate relaxed drape fit and washed vintage aesthetic styling.',
            'img' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800',
            'stock' => 25,
            'rating' => 4.7,
            'reviews_count' => 80
        ]);
        Product::create([
            'category_id' => $streetwear->id,
            'name' => 'Urban Hype Cargo Pants',
            'slug' => 'urban-hype-cargo-pants',
            'brand' => 'HypeThread',
            'price' => 3499.00,
            'description' => 'Tough ripstop cotton material with multi-utility tactical side pockets and comfortable adjustable elastic cuff adjustments.',
            'img' => 'https://images.unsplash.com/photo-1517423568366-8b83523034fd?w=800',
            'stock' => 18,
            'rating' => 4.5,
            'reviews_count' => 64
        ]);

        // Travel Gear
        Product::create([
            'category_id' => $travel->id,
            'name' => 'Nomad Waterproof Backpack',
            'slug' => 'nomad-waterproof-backpack',
            'brand' => 'Nomad Co',
            'price' => 6499.00,
            'description' => 'Constructed from durable ballistic nylon. Dedicated 16-inch fleece laptop sleeve and hidden anti-theft organizer compartments.',
            'img' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800',
            'stock' => 22,
            'rating' => 4.8,
            'reviews_count' => 112
        ]);
        Product::create([
            'category_id' => $travel->id,
            'name' => 'Premium Polycarbonate Cabin Suitcase',
            'slug' => 'premium-polycarbonate-cabin-suitcase',
            'brand' => 'Nomad Co',
            'price' => 12999.00,
            'description' => 'Ultra-lightweight hard shell with 360-degree silent dual spinner wheels, integrated TSA lock, and premium internal organization partition.',
            'img' => 'https://images.unsplash.com/photo-1565026057447-bc90a3dceb87?w=800',
            'stock' => 14,
            'rating' => 4.9,
        ]);
    }
}
