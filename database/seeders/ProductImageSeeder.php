<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        // Image URLs for men and women
        $menImage = 'https://nld.sandro-paris.com/dw/image/v2/BCMW_PRD/on/demandware.static/-/Sites-master-catalog/default/dwe922c787/images/hi-res/Sandro_SHPPA01461-24_H_1.jpg?sw=800&sh=800';
        $womenImage = 'https://nld.sandro-paris.com/dw/image/v2/BCMW_PRD/on/demandware.static/-/Sites-master-catalog/default/dw75267f13/images/hi-res/Sandro_SFPCA01053-47_F_1.jpg?sw=800&sh=800';

        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            // Determine which image to use
            $imageUrl = str_contains($product->name, 'Men’s T-Shirt') ? $menImage : $womenImage;

            // Create the product image
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => $imageUrl,
                'is_default' => true,
            ]);
        }
    }
}

