<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart items.
     */
    public function index()
    {

        $cart = Cart::where('user_id', Auth::id())->with('cartItems.product')->first();
        $product = Product::all();
        return view('carts.index',compact('cart','product'));
    }

    /**
     * Add an item to the cart (or update quantity if it exists).
     */
   // Add a product to the cart
    public function addToCart(Request $request, $productId)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to add items to the cart.');
        }

        $user = Auth::user();

        // Find the product
        $product = Product::findOrFail($productId);

        // Check if the user already has a cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if the product already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            return redirect()->route('carts.index')->with('warning', 'Product is already in cart!');
        } else {
            // If not, add a new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('carts.index')->with('success', 'Product added to cart!');
    }

    /**
     * Store a new cart (create an empty cart if one doesn't exist).
     */
    public function store()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        return redirect()->route('carts.index')->with('success','Cart created successfully');
    }
}
