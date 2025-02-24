<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
   // Add a product to the cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $request->product_id
            ],
            [
                'quantity' => $request->quantity,
            ]
        );

        return redirect()->route('carts.index')->with('success', 'Item added to cart!');
    }

    // Update the quantity of a cart item
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('carts.index')->with('success', 'Cart item updated!');
    }

    // Remove an item from the cart
    public function destroy($id)
    {
        $cartItem = CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('carts.index')->with('success', 'Item removed from cart!');
    }
}
