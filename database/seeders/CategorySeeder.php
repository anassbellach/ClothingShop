<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Men',
            'slug' => 'men',
        ]);

        Category::create([
            'name' => 'Women',
            'slug' => 'women',
        ]);

        // Add more categories as needed
    }
}
