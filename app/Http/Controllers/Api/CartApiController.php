<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartApiController extends Controller
{
    /**
     * Get the current user's cart with items.
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
        ->with(['cartItems.product' => function ($query) {
            $query->with('images'); // Ensure product images are included
        }])
        ->first();
    
    if (!$cart) {
        return response()->json(['message' => 'Cart is empty'], 200);
    }
    
    // Transform product image paths into full URLs
    $cart->cartItems->each(function ($cartItem) {
        if ($cartItem->product && $cartItem->product->images->isNotEmpty()) {
            $cartItem->product->images->transform(function ($image) {
                $image->image = $image->image ? url('storage/' . $image->image) : null;
                return $image;
            });
        }
    });
    
    return response()->json(['cart' => $cart], 200);
    
    }

    /**
     * Add a product to the cart or update quantity.
     */
    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();

        // Find the product
        $product = Product::findOrFail($productId);

        // Get or create the user's cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if product already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            return response()->json(['message' => 'Product is already in cart!']);
        } else {
            // Add a new cart item
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart!',
            'cartItem' => $cartItem->load('product'), // Include product details
        ], 201);
    }

    /**
     * Create a new empty cart.
     */
    public function store()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        return response()->json([
            'message' => 'Cart created successfully',
            'cart' => $cart,
        ], 201);
    }

    public function clearCart()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $cart = Cart::where('user_id', $user->id)->first();
    
        if (!$cart) {
            return response()->json(['message' => 'Cart is already empty'], 200);
        }
    
        // Check if there are cart items before deleting
        if ($cart->cartItems()->exists()) {
            $cart->cartItems()->delete(); // Delete all cart items
        }
    
        return response()->json(['message' => 'Cart cleared successfully'], 200);
    }
    
    
}
