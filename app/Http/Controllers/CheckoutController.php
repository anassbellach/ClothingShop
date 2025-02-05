<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);

        $userId = auth()->check() ? auth()->id() : null; // Allow guests

        // Retrieve the user's cart or guest cart using session ID
        $cart = Cart::where('user_id', $userId)->orWhere('session_id', session()->getId())->first();
        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Your cart is empty.'], 400);
        }

        DB::beginTransaction();
        try {
            // Create an order
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $cartItems->sum(fn($item) => $item->product->price * $item->quantity),
                'status' => 'pending',
                'payment_method' => 'stripe',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Decrease stock after placing the order
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Clear the cart items after the order is placed
            CartItem::where('cart_id', $cart->id)->delete();

            // Create a Stripe Checkout session
            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($cartItems as $cartItem) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => ['name' => $cartItem->product->name],
                        'unit_amount' => $cartItem->product->price * 100, // Stripe uses cents
                    ],
                    'quantity' => $cartItem->quantity,
                ];
            }

            // Create Stripe session
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
                'cancel_url' => route('checkout.cancel'),
            ]);

            DB::commit();

            // Redirect the user to Stripe Checkout page
            return redirect($session->url); // Redirect to Stripe Checkout

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function startCheckout(Request $request)
    {
        // If the user is authenticated, you can redirect to the authenticated checkout page
        if (Auth::check()) {
            return redirect()->route('checkout.index');  // Ensure the route 'checkout.index' exists
        }

        // Redirect guest users to the guest checkout page
        return redirect()->route('Checkout.GuessCheckout');
    }

    public function success(Request $request)
    {
        // The user is redirected here after successful payment
        return Inertia::render('Checkout/Success', [
            'message' => 'Your payment was successful!'
        ]);
    }

    public function cancel()
    {
        // The user is redirected here if they cancel the payment
        return Inertia::render('Checkout/Cancel', [
            'message' => 'Your payment was canceled.'
        ]);
    }
}
