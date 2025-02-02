<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        // Get first 10 products for men and assign to category 2 (Heren)
        $mensProducts = Product::where('slug', 'LIKE', 'mens-t-shirt-%')->pluck('id');
        foreach ($mensProducts as $productId) {
            ProductCategory::create([
                'product_id' => $productId,
                'category_id' => 1,
            ]);
        }

        // Get first 10 products for women and assign to category 1 (Dames)
        $womensProducts = Product::where('slug', 'LIKE', 'womens-dress-%')->pluck('id');
        foreach ($womensProducts as $productId) {
            ProductCategory::create([
                'product_id' => $productId,
                'category_id' => 2,
            ]);
        }
    }
}

