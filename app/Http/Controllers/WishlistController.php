<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the wishlist items.
     */
    public function index()
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->with('wishlistItems.product')->first();
        $product=Product::all();
        return view('wishlist.index', compact('wishlist'));
    }

    /**
     * Add an item to the wishlist.
     */
    public function addToWishlist(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to add items to the wishlist.');
        }

        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // Find or create the wishlist
        $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

        // Check if the item is already in the wishlist
        $wishlistItem = WishlistItem::where('wishlist_id', $wishlist->id)
                                    ->where('product_id', $productId)
                                    ->first();

        if ($wishlistItem) {
            return redirect()->route('wishlist.index')->with('warning', 'Product is already in wishlist!');
        }

        // Add the product to the wishlist
        WishlistItem::create([
            'wishlist_id' => $wishlist->id,
            'product_id' => $productId
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Product added to wishlist!');
    }

    // /**
    //  * Remove an item from the wishlist.
    //  */
    // public function removeFromWishlist($productId)
    // {
    //     $wishlist = Wishlist::where('user_id', Auth::id())->first();

    //     if ($wishlist) {
    //         WishlistItem::where('wishlist_id', $wishlist->id)
    //                     ->where('product_id', $productId)
    //                     ->delete();
    //     }

    //     return redirect()->route('wishlist.index')->with('success', 'Product removed from wishlist!');
    // }

    /**
     * Store a new wishlist (create an empty wishlist if one doesn't exist).
     */
    public function store()
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);
        return redirect()->route('wishlist.index')->with('success', 'Wishlist created successfully');
    }
}
