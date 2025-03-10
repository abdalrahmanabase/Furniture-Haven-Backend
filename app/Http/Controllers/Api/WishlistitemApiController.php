<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistitemApiController extends Controller
{
    /**
     * Add a product to the wishlist.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
    
        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
    
        $wishlistItem = WishlistItem::updateOrCreate([
            'product_id' => $request->product_id,
            'wishlist_id' => $wishlist->id,
        ]);
    
        return response()->json([
            'message' => 'Item added to wishlist!',
            'wishlist_item' => [
                'id' => $wishlistItem->id,
                'product_id' => $wishlistItem->product_id,
                'product_name' => $wishlistItem->product->title,
                'product_price' => $wishlistItem->product->price,
                'product_image' => asset('storage/' . $wishlistItem->product->image),
            ]
        ], 201);
    }
    

    /**
     * Remove an item from the wishlist.
     */
    public function destroy($id)
    {
        $wishlistItem = WishlistItem::where('id', $id)
            ->whereHas('wishlist', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $wishlistItem->delete();

        return response()->json([
            'message' => 'Item removed from wishlist!',
        ], 200);
    }
}
