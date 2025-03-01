<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
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

        // Calculate the total price
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->total_price = $totalPrice;
        $order->status = 'pending'; // Default status
        $order->payment_method = 'cash'; // Default payment method
        $order->save();

        // Create order items and update product quantities
        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity; 
            $orderItem->save();
        }

        // Clear the cart
        $cart->cartItems()->delete();

        return redirect()->route('order.index')->with('success', 'Your order has been placed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('order.show', compact('order'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        return redirect()->route('order.index')->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    
}