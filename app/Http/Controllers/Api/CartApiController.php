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
        $cart = Cart::where('user_id', Auth::id())->with('cartItems.product')->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 200);
        }

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
            return response()->json(['message' => 'Product is already in cart!'], 409);
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
            'cartItem' => $cartItem,
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
}
