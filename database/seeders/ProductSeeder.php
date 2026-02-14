<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freshFish = Category::where('name', 'Fresh Fish')->first();
        $shellfish = Category::where('name', 'Shellfish')->first();
        $specialties = Category::where('name', 'Seafood Specialties')->first();
        $smoked = Category::where('name', 'Smoked & Cured')->first();

        $products = [
            // Fresh Fish
            [
                'category_id' => $freshFish->id,
                'name' => 'Atlantic Salmon',
                'description' => 'Premium Atlantic salmon, rich in omega-3 fatty acids. Perfect for grilling or baking.',
                'price' => 24.99,
                'stock' => 50,
                'image' => 'specials-1.png',
            ],
            [
                'category_id' => $freshFish->id,
                'name' => 'Tuna Steak',
                'description' => 'Fresh tuna steak, ideal for searing and serving rare.',
                'price' => 32.99,
                'stock' => 30,
                'image' => 'specials-2.png',
            ],
            [
                'category_id' => $freshFish->id,
                'name' => 'Sea Bass',
                'description' => 'Delicate white sea bass with a mild, sweet flavor.',
                'price' => 18.99,
                'stock' => 40,
                'image' => 'specials-3.png',
            ],
            // Shellfish
            [
                'category_id' => $shellfish->id,
                'name' => 'Jumbo Shrimp',
                'description' => 'Large, succulent shrimp perfect for cocktails or grilling.',
                'price' => 22.99,
                'stock' => 60,
                'image' => 'specials-4.png',
            ],
            [
                'category_id' => $shellfish->id,
                'name' => 'Maine Lobster',
                'description' => 'Fresh Maine lobster, sweet and tender meat.',
                'price' => 45.99,
                'stock' => 20,
                'image' => 'specials-5.png',
            ],
            [
                'category_id' => $shellfish->id,
                'name' => 'Blue Crab',
                'description' => 'Sweet blue crab meat, perfect for crab cakes.',
                'price' => 28.99,
                'stock' => 35,
                'image' => 'specials-1.png',
            ],
            // Seafood Specialties
            [
                'category_id' => $specialties->id,
                'name' => 'Seafood Paella Mix',
                'description' => 'Ready-to-cook mix of various seafood for authentic paella.',
                'price' => 35.99,
                'stock' => 25,
                'image' => 'specials-2.png',
            ],
            [
                'category_id' => $specialties->id,
                'name' => 'Fisherman\'s Stew',
                'description' => 'Traditional seafood stew with mixed fish and shellfish.',
                'price' => 28.99,
                'stock' => 30,
                'image' => 'specials-3.png',
            ],
            // Smoked & Cured
            [
                'category_id' => $smoked->id,
                'name' => 'Smoked Salmon',
                'description' => 'Traditional cold-smoked salmon, perfect for appetizers.',
                'price' => 26.99,
                'stock' => 45,
                'image' => 'specials-4.png',
            ],
            [
                'category_id' => $smoked->id,
                'name' => 'Cured Herring',
                'description' => 'Classic cured herring with traditional spices.',
                'price' => 16.99,
                'stock' => 55,
                'image' => 'specials-5.png',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
