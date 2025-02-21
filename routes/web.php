<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Home Page
Route::get('/', function () {
    return Inertia::render('Home/Index');
})->name('home');

Route::get('login', [AuthController::class, 'loginPage'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');
Route::post('logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.store');


// 🛒 Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/update/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/destroy/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

// 🏁 Checkout Routes
Route::post('/checkout/start', [CheckoutController::class, 'startCheckout'])->name('checkout.start'); // Handles guest vs logged-in user redirect
Route::get('/guest-checkout', fn() => Inertia::render('Checkout/GuestCheckout'))->name('Checkout.GuessCheckout');

// Allow both guests & logged-in users to submit checkout form
Route::post('/checkout', [CheckoutController::class, 'store']);

// Only logged-in users can access normal checkout page
Route::middleware('auth')->get('/checkout', fn() => Inertia::render('Checkout'))->name('checkout.index');

// 💳 Stripe Payment Routes
Route::post('/stripe/checkout', [StripeController::class, 'createCheckoutSession'])->name('stripe.checkout');
Route::post('/stripe/webhook', [StripeController::class, 'handleStripeWebhook']);

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');


Route::get('/checkout/cancel', function () {
    return Inertia::render('Checkout/Cancel'); // You can create a Vue page for the cancel
})->name('checkout.cancel');


// Route for category-based product listing
Route::get('/{category}', [ProductController::class, 'index'])->name('products.index');

// Route for individual product details
Route::get('/{category}/{product}', [ProductController::class, 'show'])->name('products.show');
