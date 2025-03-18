<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderitemApiController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('product')->get();

        return response()->json(['orderItems' => $orderItems], 200);
    }

    /**
     * Display the specified order item.
     */
    public function show($id)
    {
        $orderItem = OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', Auth::id());
        })->with('product')->findOrFail($id);

        return response()->json(['orderItem' => $orderItem], 200);
    }
}
