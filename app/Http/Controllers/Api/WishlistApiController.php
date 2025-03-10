<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistApiController extends Controller
{
    /**
     * Get all wishlist items for the authenticated user.
     */
    public function index()
{
    $wishlist = Wishlist::where('user_id', Auth::id())
        ->with('wishlistItems.product') // Include the images relationship
        ->first();

    if ($wishlist) {
        // Map wishlist items to include the main product image URL
        $wishlist->wishlistItems->map(function ($item) {
            if ($item->product->images->isNotEmpty()) {
                // Use the first image as the main image
                $item->product->image_url = url('storage/' . $item->product->images[0]->image);
            } else {
                // Fallback if no images are available
                $item->product->image_url = null;
            }
            return $item;
        });
    }

    return response()->json([
        'wishlist' => $wishlist ?? [],
        'message' => $wishlist ? 'Wishlist retrieved successfully.' : 'No wishlist found.',
    ], 200);
}
    /**
     * Add a product to the wishlist.
     */
    public function addToWishlist(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        // Find or create the wishlist
        $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);

        // Check if the item is already in the wishlist
        $wishlistItem = WishlistItem::where('wishlist_id', $wishlist->id)
                                    ->where('product_id', $productId)
                                    ->first();

        if ($wishlistItem) {
            return response()->json([
                'message' => 'Product is already in the wishlist!'
            ], 409);
        }

        // Add product to wishlist
        WishlistItem::create([
            'wishlist_id' => $wishlist->id,
            'product_id' => $productId
        ]);

        return response()->json([
            'message' => 'Product added to wishlist successfully!',
            'wishlist' => $wishlist->load('wishlistItems.product')
        ], 201);
    }

    /**
     * Remove a product from the wishlist.
     */
    public function removeFromWishlist($productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->first();

        if ($wishlist) {
            WishlistItem::where('wishlist_id', $wishlist->id)
                        ->where('product_id', $productId)
                        ->delete();
        }

        return response()->json([
            'message' => 'Product removed from wishlist successfully!'
        ], 200);
    }

    /**
     * Create a wishlist if one doesn't exist.
     */
    public function store()
    {
        $wishlist = Wishlist::firstOrCreate(['user_id' => Auth::id()]);

        return response()->json([
            'message' => 'Wishlist created successfully!',
            'wishlist' => $wishlist->load('wishlistItems.product')
        ], 201);
    }
}
