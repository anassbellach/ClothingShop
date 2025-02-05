<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index()
    {
        $cart = Cart::with('items.product.images')->firstOrCreate([
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
        ]);

        return inertia('Cart/Index', [
            'cart' => $cart,
        ]);
    }


    /**
     * Store a new item in the cart (Add to cart).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        // Find or create cart
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
        ]);

        // Check if product is already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        // Return Inertia response with updated cart data
        return inertia('Cart/Index', [
            'cart' => $cart->load('items.product'),
        ]);
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'message' => 'Cart updated successfully!',
            'cartItem' => $cartItem,
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())
            ->orWhere('session_id', session()->getId())
            ->first();

        if ($cart) {
            $cart->items()->delete(); // Remove all items
        }

        return response()->json([
            'message' => 'Cart cleared successfully.',
        ]);
    }

}
