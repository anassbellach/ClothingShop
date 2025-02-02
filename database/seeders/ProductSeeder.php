<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            // Create Men’s T-Shirt
            Product::create([
                'name' => 'Men’s T-Shirt ' . $i,
                'slug' => 'mens-t-shirt-' . $i,
                'description' => 'A comfortable and stylish t-shirt for men.',
                'price' => 29.99,
                'sale_price' => 24.99,
                'sku' => 'MT' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'stock_quantity' => 100,
                'is_active' => true,
            ]);

            // Create Women’s Dress
            Product::create([
                'name' => 'Women’s Dress ' . $i,
                'slug' => 'womens-dress-' . $i,
                'description' => 'An elegant dress for women.',
                'price' => 59.99,
                'sale_price' => null,
                'sku' => 'WD' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'stock_quantity' => 50,
                'is_active' => true,
            ]);
        }

        // Add more products as needed
    }
}
