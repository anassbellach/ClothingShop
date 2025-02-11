<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Inertia\Inertia;

class CheckoutController extends Controller
{

    public function startCheckout(Request $request)
    {
        // If the user is authenticated, you can redirect to the authenticated checkout page
        if (Auth::check()) {
            return redirect()->route('checkout.index');  // Ensure the route 'checkout.index' exists
        }

        // Redirect guest users to the guest checkout page
        return redirect()->route('Checkout.GuessCheckout');
    }

public function store(Request $request)
{
    Log::info('Checkout request received', ['request' => $request->all()]);

    try {
        // Validate input
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);

        Log::info('Validation successful', $validated);

        $userId = auth()->check() ? auth()->id() : null;
        $cart = Cart::where('user_id', $userId)->orWhere('session_id', session()->getId())->first();

        if (!$cart) {
            Log::error('Cart not found for user or session', ['user_id' => $userId, 'session_id' => session()->getId()]);
            return response()->json(['error' => 'Cart not found.'], 400);
        }

        $cartItems = $cart->items;
        if ($cartItems->isEmpty()) {
            Log::error('Cart is empty');
            return response()->json(['error' => 'Your cart is empty.'], 400);
        }

        DB::beginTransaction();

        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        Log::info('Total amount calculated', ['amount' => $totalAmount]);

        $order = Order::create([
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
        ]);

        // Prepare Stripe checkout session
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        foreach ($cartItems as $cartItem) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => ['name' => $cartItem->product->name],
                    'unit_amount' => $cartItem->product->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        Log::info('Stripe line items prepared', $lineItems);

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
            'cancel_url' => route('checkout.cancel'),
        ]);

        Log::info('Stripe session created', ['session_id' => $session->id]);

        $order->update(['stripe_session_id' => $session->id]);

        DB::commit();

        return response()->json(['checkout_url' => $session->url]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Checkout error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Something went wrong during checkout.'], 500);
    }
}


    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid session.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Retrieve session from Stripe
            $session = StripeSession::retrieve($sessionId);

            // Find the order using the stripe_session_id
            $order = Order::where('stripe_session_id', $sessionId)->first();

            if (!$order) {
                Log::error('Order not found for Stripe session', ['session_id' => $sessionId]);
                return redirect()->route('home')->with('error', 'Order not found.');
            }

            // Update order status to completed
            $order->update([
                'status' => 'completed',
                'payment_status' => 'paid',
            ]);

            Log::info('Order marked as paid', ['order_id' => $order->id]);

            return Inertia::render('Checkout/Success', [
                'order' => [
                    'id' => $order->id,
                    'total_amount' => $order->total_amount,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe checkout success error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('home')->with('error', 'Something went wrong while confirming the payment.');
        }
    }


    public function cancel()
    {
        return Inertia::render('Checkout/Cancel', [
            'message' => 'Your payment was canceled.'
        ]);
    }

}
