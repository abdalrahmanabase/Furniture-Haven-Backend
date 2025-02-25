<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Http\Controllers\Api\OrderApiController;

class CheckoutApiController extends Controller
{
    /**
     * Get checkout details including cart items and shipping addresses.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch the user's cart
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        // Fetch cart items with products
        $cartItems = $cart->cartItems()->with('product')->get();

        // Fetch user's shipping addresses
        $addresses = ShippingAddress::where('user_id', $user->id)->get();

        // Check if a selected shipping address exists in session
        $selectedAddress = session('selected_address_id') 
            ? ShippingAddress::find(session('selected_address_id')) 
            : null;

        return response()->json([
            'cartItems' => $cartItems,
            'addresses' => $addresses,
            'selectedAddress' => $selectedAddress
        ]);
    }

    /**
     * Select a shipping address for checkout.
     */
    public function selectAddress(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id'
        ]);

        // Store selected address in session
        session(['selected_address_id' => $request->shipping_address_id]);

        return response()->json(['message' => 'Shipping address selected successfully.'], 200);
    }

    /**
     * Confirm the order and clear the cart.
     */
    public function confirmOrder(Request $request)
    {
        $user = Auth::user();

        // Fetch the user's cart
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        // Create the order using the OrderApiController's store method
        $orderController = new OrderApiController();
        $orderResponse = $orderController->store($request);

        // Clear the cart
        $cart->cartItems()->delete();

        return response()->json([
            'message' => 'Order confirmed successfully!',
            'order' => $orderResponse
        ], 201);
    }
}
