<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
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
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->status = 'pending';
        $order->save();

        $cartItems = CartItem::where('user_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $cartItem->product_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->save();

            $product = Product::find($cartItem->product_id);
            $product->quantity -= $cartItem->quantity;
            $product->save();

            $cartItem->delete();
        }

        return redirect()->route('order.index')->with('success', 'Your order has been placed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
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
