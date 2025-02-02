<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($category)
    {
        // Find the category by slug (e.g., 'dames' or 'heren')
        $category = Category::where('slug', $category)->firstOrFail();

        // Get products in this category
        $products = Product::whereHas('categories', function ($query) use ($category) {
            $query->where('categories.id', $category->id);
        })
            ->with('images')
            ->where('is_active', true)
            ->get();

        return inertia('Products/Index', [
            'products' => $products,
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($category, $sku)
    {
        // Find the category by slug
        $category = Category::where('slug', $category)->firstOrFail();

        // Find the product by sku and eager load related data
        $product = Product::with(['images', 'categories'])
            ->where('sku', $sku)  // Fetch by SKU instead of slug
            ->firstOrFail();

        return inertia('Products/Show', [
            'product' => $product,
            'category' => $category,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
