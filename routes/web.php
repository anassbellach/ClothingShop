<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Home/Index');
});

// Route for category-based product listing
Route::get('/{category}', [ProductController::class, 'index'])->name('products.index');

// Route for individual product details
Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');

