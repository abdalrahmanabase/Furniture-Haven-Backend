<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistItemController extends Controller
{
    // Add a product to the wishlist
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);

        $wishlistitem=WishlistItem::updateOrCreate([
            'product_id' => $request->product_id,
            'wishlist_id' => $wishlist->id,
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Item added to wishlist!');
    }

    // Remove an item from the wishlist
    public function destroy($id)
    {
        $wishlistitem = WishlistItem::where('id', $id)
        ->whereHas('wishlist', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->firstOrFail();

    $wishlistitem->delete();

        return redirect()->route('wishlist.index')->with('success', 'Item removed from wishlist!');
    }
}
