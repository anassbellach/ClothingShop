<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Home/Index');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');


// Route for category-based product listing
Route::get('/{category}', [ProductController::class, 'index'])->name('products.index');

// Route for individual product details
Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');
