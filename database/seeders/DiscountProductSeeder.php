<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DiscountProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get all discounts and products
        $discounts = Discount::all();
        $products = Product::all();

        // Attach random products to each discount
        foreach ($discounts as $discount) {
            // Attach 3 random products, and also provide the created_at/updated_at timestamps
            $randomProducts = $products->random(3);

            // Attach each product to the discount with Unix timestamps
            foreach ($randomProducts as $product) {
                $discount->products()->attach($product->id, [
                    'created_at' => now()->timestamp, // Unix timestamp for created_at
                    'updated_at' => now()->timestamp, // Unix timestamp for updated_at
                ]);
            }
        }

        $this->command->info('Discount products seeded successfully!');
    }
}
