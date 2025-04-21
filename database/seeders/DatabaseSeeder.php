<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction; // Add this import
use App\Models\Review; // Also need to import Review model

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'email_verified_at' => '2025-04-09 22:48:21',
                'created_at' => '2025-04-09 22:47:27',
                'updated_at' => '2025-04-09 22:48:21'
            ]
        );

        $categories = [
            ['name' => 'Power Tools', 'slug' => 'power-tools', 'description' => 'Electric and battery-powered tools for construction and woodworking'],
            ['name' => 'Hand Tools', 'slug' => 'hand-tools', 'description' => 'Traditional manual tools for various tasks'],
            ['name' => 'Fasteners', 'slug' => 'fasteners', 'description' => 'Nails, screws, bolts and other hardware fasteners'],
            ['name' => 'Safety Equipment', 'slug' => 'safety-equipment', 'description' => 'Protective gear for construction and industrial work'],
            ['name' => 'Paint & Supplies', 'slug' => 'paint-supplies', 'description' => 'Paints, brushes, rollers and related materials']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Add the specified user
        User::create([
            'name' => 'AllanRoi',
            'email' => 'allanmonforte123@gmail.com',
            'email_verified_at' => '2025-04-09 22:48:21',
            'password' => bcrypt('123123123'),
            'profile_photo_path' => 'profile-photos\0plLWwfHwau7COb98GF7egFfj4bDBHK7bBgfOBg8.jpg',
            'role' => 'customer',
            'created_at' => '2025-04-09 22:47:27',
            'updated_at' => '2025-04-09 22:48:21'
        ]);

        User::create([
            'name' => 'Allan123',
            'email' => 'allanmonforte1@gmail.com',
            'email_verified_at' => '2025-04-09 22:55:08',
            'password' => bcrypt('123123123'),
            'profile_photo_path' => 'profile-photos\0plLWwfHwau7COb98GF7egFfj4bDBHK7bBgfOBg8.jpg',
            'role' => 'customer',
            'created_at' => '2025-04-09 22:54:35',
            'updated_at' => '2025-04-10 11:57:46'
        ]);

        $products = [
            ['name' => 'Cordless Drill', 'slug' => 'cordless-drill', 'description' => '18V Lithium-Ion Cordless Drill/Driver Kit', 'price' => 129.99, 'category_id' => 1, 'stock' => 45],
            ['name' => 'Circular Saw', 'slug' => 'circular-saw', 'description' => '7-1/4 Inch Circular Saw with Laser Guide', 'price' => 89.99, 'category_id' => 1, 'stock' => 32],
            ['name' => 'Hammer', 'slug' => 'hammer', 'description' => '16 oz Curved Claw Hammer with Fiberglass Handle', 'price' => 14.99, 'category_id' => 2, 'stock' => 78],
            ['name' => 'Screwdriver Set', 'slug' => 'screwdriver-set', 'description' => '8-Piece Precision Screwdriver Set', 'price' => 12.99, 'category_id' => 2, 'stock' => 56],
            ['name' => 'Wood Screws', 'slug' => 'wood-screws', 'description' => '#8 x 1-1/4 Inch Coarse Thread Drywall Screws (1 lb)', 'price' => 5.99, 'category_id' => 3, 'stock' => 120],
            ['name' => 'Safety Glasses', 'slug' => 'safety-glasses', 'description' => 'Clear Anti-Fog Safety Glasses with UV Protection', 'price' => 8.99, 'category_id' => 4, 'stock' => 65],
            ['name' => 'Paint Roller', 'slug' => 'paint-roller', 'description' => '9 Inch Paint Roller with 1/2 Inch Nap Cover', 'price' => 6.99, 'category_id' => 5, 'stock' => 42],
            ['name' => 'Paint Brush', 'slug' => 'paint-brush', 'description' => '2 Inch Angled Sash Paint Brush', 'price' => 4.99, 'category_id' => 5, 'stock' => 38],
            ['name' => 'Level', 'slug' => 'level', 'description' => '48 Inch Aluminum Level with Magnetic Edge', 'price' => 24.99, 'category_id' => 2, 'stock' => 27],
            ['name' => 'Tape Measure', 'slug' => 'tape-measure', 'description' => '25 ft. Tape Measure with Magnetic Hook', 'price' => 12.99, 'category_id' => 2, 'stock' => 53],
            ['name' => 'Utility Knife', 'slug' => 'utility-knife', 'description' => 'Retractable Utility Knife with 5 Blades', 'price' => 7.99, 'category_id' => 2, 'stock' => 67],
            ['name' => 'Pliers Set', 'slug' => 'pliers-set', 'description' => '3-Piece Slip Joint Pliers Set', 'price' => 19.99, 'category_id' => 2, 'stock' => 39],
            ['name' => 'Wrench Set', 'slug' => 'wrench-set', 'description' => '10-Piece Combination Wrench Set', 'price' => 29.99, 'category_id' => 2, 'stock' => 31],
            ['name' => 'Socket Set', 'slug' => 'socket-set', 'description' => '40-Piece Socket Set with Case', 'price' => 49.99, 'category_id' => 2, 'stock' => 22],
            ['name' => 'Work Gloves', 'slug' => 'work-gloves', 'description' => 'Leather Palm Work Gloves, Pair', 'price' => 9.99, 'category_id' => 4, 'stock' => 58],
            ['name' => 'Hard Hat', 'slug' => 'hard-hat', 'description' => 'ANSI-Compliant Hard Hat with 4-Point Suspension', 'price' => 19.99, 'category_id' => 4, 'stock' => 36],
            ['name' => 'Ear Protection', 'slug' => 'ear-protection', 'description' => 'Noise Reduction Rating 27 dB Ear Muffs', 'price' => 14.99, 'category_id' => 4, 'stock' => 41],
            ['name' => 'Dust Mask', 'slug' => 'dust-mask', 'description' => 'N95 Particulate Respirator Mask (10-Pack)', 'price' => 12.99, 'category_id' => 4, 'stock' => 87],
            ['name' => 'Knee Pads', 'slug' => 'knee-pads', 'description' => 'Gel-Foam Knee Pads with Adjustable Straps', 'price' => 16.99, 'category_id' => 4, 'stock' => 29],
            ['name' => 'Paint Tray', 'slug' => 'paint-tray', 'description' => '9 Inch Plastic Paint Tray with Liner', 'price' => 3.99, 'category_id' => 5, 'stock' => 72],
            ['name' => 'Painters Tape', 'slug' => 'painters-tape', 'description' => '1.41 Inch x 60 Yards Blue Painters Tape', 'price' => 5.99, 'category_id' => 5, 'stock' => 72],
            ['name' => 'Drop Cloth', 'slug' => 'drop-cloth', 'description' => '9 ft x 12 ft Canvas Drop Cloth', 'price' => 14.99, 'category_id' => 5, 'stock' => 72],
            ['name' => 'Paint Stirrer', 'slug' => 'p paint-stirrer', 'description' => 'Pack of 50 Wooden Paint Stirrers', 'price' => 2.99, 'category_id' => 5, 'stock' => 72],
            ['name' => 'Paint Can Opener', 'slug' => 'paint-can-opener', 'description' => 'Metal Paint Can Opener Tool', 'price' => 1.99, 'category_id' => 5, 'stock' => 72],
            ['name' => 'Impact Driver', 'slug' => 'impact-driver', 'description' => '20V MAX Lithium-Ion Cordless Impact Driver', 'price' => 149.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Reciprocating Saw', 'slug' => 'reciprocating-saw', 'description' => '12 Amp Corded Reciprocating Saw', 'price' => 99.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Orbital Sander', 'slug' => 'orbital-sander', 'description' => '5 Inch Random Orbit Sander with Dust Bag', 'price' => 59.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Jigsaw', 'slug' => 'jigsaw', 'description' => '6.5 Amp Corded Variable Speed Jigsaw', 'price' => 69.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Angle Grinder', 'slug' => 'angle-grinder', 'description' => '4-1/2 Inch Angle Grinder with Paddle Switch', 'price' => 79.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Router', 'slug' => 'router', 'description' => '2-1/4 HP Fixed Base Router', 'price' => 119.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Table Saw', 'slug' => 'table-saw', 'description' => '10 Inch Portable Jobsite Table Saw', 'price' => 399.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Miter Saw', 'slug' => 'miter-saw', 'description' => '10 Inch Sliding Compound Miter Saw', 'price' => 299.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Air Compressor', 'slug' => 'air-compressor', 'description' => '6 Gallon Pancake Air Compressor', 'price' => 129.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Brad Nails', 'slug' => 'brad-nails', 'description' => '18 Gauge 1-1/4 Inch Brad Nails (1000-Pack)', 'price' => 8.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Finish Nails', 'slug' => 'finish-nails', 'description' => '16 Gauge 2 Inch Finish Nails (1000-Pack)', 'price' => 9.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Drywall Screws', 'slug' => 'drywall-screws', 'description' => '#6 x 1-1/4 Inch Drywall Screws (1 lb)', 'price' => 4.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Deck Screws', 'slug' => 'deck-screws', 'description' => '#8 x 2-1/2 Inch Deck Screws (5 lb)', 'price' => 24.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Lag Screws', 'slug' => 'lag-screws', 'description' => '1/4 x 3 Inch Hex Lag Screws (25-Pack)', 'price' => 12.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Carriage Bolts', 'slug' => 'carriage-bolts', 'description' => '1/4-20 x 2 Inch Carriage Bolts (10-Pack)', 'price' => 5.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Hex Nuts', 'slug' => 'hex-nuts', 'description' => '1/4-20 Hex Nuts (25-Pack)', 'price' => 3.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Washers', 'slug' => 'washers', 'description' => '1/4 Inch Flat Washers (100-Pack)', 'price' => 4.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Anchors', 'slug' => 'anchors', 'description' => '1/4 Inch Plastic Wall Anchors (50-Pack)', 'price' => 3.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Picture Hangers', 'slug' => 'picture-hangers', 'description' => 'Assorted Picture Hangers Kit (50-Pack)', 'price' => 6.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Wire Nuts', 'slug' => 'wire-nuts', 'description' => 'Assorted Wire Connectors (50-Pack)', 'price' => 5.99, 'category_id' => 3, 'stock' => 72],
            ['name' => 'Extension Cord', 'slug' => 'extension-cord', 'description' => '50 ft. 16/3 Outdoor Extension Cord', 'price' => 39.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Power Strip', 'slug' => 'power-strip', 'description' => '6-Outlet Surge Protector with USB Ports', 'price' => 19.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Work Light', 'slug' => 'work-light', 'description' => 'LED Tripod Work Light with 3 Light Modes', 'price' => 29.99, 'category_id' => 1, 'stock' => 72],
            ['name' => 'Tool Bag', 'slug' => 'tool-bag', 'description' => '20 Inch Heavy-Duty Tool Bag with Pockets', 'price' => 24.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Tool Box', 'slug' => 'tool-box', 'description' => '22 Inch Plastic Tool Box with T tray', 'price' => 19.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Tool Belt', 'slug' => 'tool-belt', 'description' => 'Adjustable Canvas Tool Belt with Pouches', 'price' => 22.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Caulk Gun', 'slug' => 'caulk-gun', 'description' => 'Heavy Duty Smooth Rod Caulk Gun', 'price' => 9.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Putty Knife', 'slug' => 'putty-knife', 'description' => '3 Inch Flexible Putty Knife', 'price' => 4.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Paint Scraper', 'slug' => 'paint-scraper', 'description' => '2 Inch Razor Blade Paint Scraper', 'price' => 6.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Chisel Set', 'slug' => 'chisel-set', 'description' => '4-Piece Wood Chisel Set', 'price' => 24.99, 'category_id' => 2, 'stock' => 72],
            ['name' => 'Files Set', 'slug' => 'files-set', 'description' => '6-Piece Needle File Set', 'price' => 12.99, 'category_id' => 2, 'stock' => 72]
        ];

        foreach ($products as $product) {
            $createdProduct = Product::create($product);
            
            // Add sample images for each product
            $images = [
                ['image_path' => 'products/'.$product['slug'].'-1.jpg'],
                ['image_path' => 'products/'.$product['slug'].'-2.jpg'],
                ['image_path' => 'products/'.$product['slug'].'-3.jpg']
            ];
            
            foreach ($images as $image) {
                $createdProduct->images()->create($image);
            }
        }

        // Create 20 additional verified users
        $additionalUsers = [];
        for ($i = 1; $i <= 20; $i++) {
            $additionalUsers[] = User::create([
                'name' => 'Customer'.$i,
                'email' => 'customer'.$i.'@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'role' => 'customer',
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ]);
        }

        // Combine all users (admin, your specified users, and new users)
        $allUsers = array_merge([User::where('email', 'admin@example.com')->first()], 
                                [User::where('email', 'allanmonforte123@gmail.com')->first()],
                                [User::where('email', 'allanmonforte1@gmail.com')->first()],
                                $additionalUsers);

        // Create transactions and reviews for each product
        $products = Product::all();
        foreach ($products as $product) {
            // Create 3-5 transactions per product
            $transactions = [];
            $reviewCount = rand(3, 4); // 3-4 reviews per product
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $allUsers[array_rand($allUsers)];
                $quantity = rand(1, 3);
                
                $transaction = Transaction::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $quantity,
                    'total_price' => $product->price * $quantity,
                    'status' => 'completed',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()
                ]);
                
                // Create review for each transaction
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'rating' => rand(3, 5), // Ratings between 3-5 stars
                    'comment' => $this->getRandomReviewComment($product->name),
                    'created_at' => $transaction->created_at,
                    'updated_at' => now()
                ]);
            }
        }
    }

    private function getRandomReviewComment($productName)
    {
        $comments = [
            "This $productName works great! Very satisfied with my purchase.",
            "The $productName is good quality for the price.",
            "I'm happy with this $productName. Does what it's supposed to.",
            "Solid $productName. Would recommend to others.",
            "The $productName exceeded my expectations. Works perfectly.",
            "Good $productName. No complaints so far.",
            "This $productName is exactly what I needed. Very useful.",
            "Impressed with this $productName. Good build quality."
        ];
        
        return $comments[array_rand($comments)];
    }
}