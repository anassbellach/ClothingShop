<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Webhook;

class StripeController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $order = Order::findOrFail($request->order_id);

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'eur',
                    'product_data' => ['name' => $item->product->name],
                    'unit_amount'  => $item->price * 100, // Stripe uses cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => url('/checkout/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url'           => url('/checkout/cancel'),
        ]);

        // 🔥 Ensure `stripe_session_id` is stored
        $order->update(['stripe_session_id' => $session->id]);

        return response()->json(['url' => $session->url]);
    }

    public function success(Request $request)
    {
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }

    public function handleStripeWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, config('services.stripe.webhook_secret')
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle checkout session completed event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Find the order with the Stripe session ID
            $order = Order::where('stripe_session_id', $session->id)->first();

            if ($order && $order->payment_status === 'pending') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing', // Optional: Change status to processing
                ]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
