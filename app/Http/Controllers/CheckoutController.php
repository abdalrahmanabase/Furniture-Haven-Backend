<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Fetch the user's cart
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            return redirect()->route('carts.index')->with('error', 'Your cart is empty.');
        }

        // Fetch cart items with products
        $cartItems = $cart->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'Your cart is empty.');
        }

        // Fetch user's shipping addresses
        $addresses = ShippingAddress::where('user_id', $user->id)->get();

        // Check if a selected shipping address exists in session
        $selectedAddress = session('selected_address_id') 
            ? ShippingAddress::find(session('selected_address_id')) 
            : null;

        return view('checkout.index', compact('cartItems', 'addresses', 'selectedAddress'));
    }

    public function selectAddress(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:shipping_addresses,id'
        ]);

        // Store selected address in session
        session(['selected_address_id' => $request->shipping_address_id]);

        return redirect()->route('checkout.index')->with('success', 'Shipping address selected successfully.');
    }

    public function confirmOrder(Request $request)
    {
        $user = Auth::user();
    
        $cart = Cart::where('user_id', $user->id)->first();
    
        if (!$cart) {
            return redirect()->route('carts.index')->with('error', 'Your cart is empty.');
        }
    
        $cartItems = $cart->cartItems()->with('product')->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('carts.index')->with('error', 'Your cart is empty.');
        }
    
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('carts.index')->with('error', 'Some items are out of stock.');
            }
        }
    
        foreach ($cartItems as $item) {
            $product = $item->product;
            $newStock = $product->stock - $item->quantity;
    
            $product->update(['stock' => $newStock]); // Directly updating stock
        }
    
        $orderController = new OrderController();
        $orderController->store($request);
    
        $cart->cartItems()->delete();
    
        return redirect()->route('order.index')->with('success', 'Order confirmed successfully!');
    }
    
}
