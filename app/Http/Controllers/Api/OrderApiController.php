<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderApiController extends Controller
{
    /**
     * Get all orders for the authenticated user.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('orderItems.product')->get();
        return response()->json(['orders' => $orders], 200);
    }

    /**
     * Place an order from the user's cart.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        // Calculate total price
        $totalPrice = $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Create a new order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'status' => 'pending', // Default status
            'payment_method' => 'cash' // Default method
        ]);

        // Create order items
        foreach ($cart->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
            ]);
        }

        // Clear the cart
        $cart->cartItems()->delete();

        return response()->json([
            'message' => 'Your order has been placed successfully.',
            'order' => $order->load('orderItems.product')
        ], 201);
    }

    /**
     * Get a specific order with its items.
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->with('orderItems.product')->findOrFail($id);
        return response()->json(['order' => $order], 200);
    }

    /**
     * Update the order status.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,canceled'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Order status updated successfully.',
            'order' => $order
        ], 200);
    }
}
