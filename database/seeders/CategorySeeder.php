<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fresh Fish',
                'description' => 'Premium quality fresh fish caught daily from the ocean'
            ],
            [
                'name' => 'Shellfish',
                'description' => 'Delicious shellfish including shrimp, crab, and lobster'
            ],
            [
                'name' => 'Seafood Specialties',
                'description' => 'Prepared seafood dishes and specialty items'
            ],
            [
                'name' => 'Smoked & Cured',
                'description' => 'Traditional smoked and cured seafood products'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
