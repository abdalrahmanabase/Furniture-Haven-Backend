<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CartitemApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\OrderitemApiController;
use App\Http\Controllers\Api\WishlistApiController;
use App\Http\Controllers\Api\WishlistitemApiController;
use App\Http\Controllers\Api\ShippingAddressApiController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\CheckoutApiController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products', ProductApiController::class);
Route::apiResource('categories', CategoryApiController::class);
Route::apiResource('brands', BrandApiController::class);
Route::get('blogs', [BlogApiController::class, 'index'])->name('blogs.index');

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/carts', [CartApiController::class, 'index']);
    Route::post('/carts', [CartApiController::class, 'store']);
    Route::delete('/carts/clear', [CartApiController::class, 'clearCart']);
    Route::apiResource('cartitems', CartitemApiController::class);
    Route::post('/carts/add/{productId}', [CartApiController::class, 'addToCart'])->name('cart.add');

    Route::apiResource('wishlist', WishlistApiController::class);
    Route::apiResource('wishlistitems', WishlistitemApiController::class);
    Route::post('/wishlist/add/{productId}', [WishlistApiController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('/wishlist/remove/{productId}', [WishlistApiController::class, 'removeFromWishlist'])->name('wishlist.remove');


    Route::apiResource('orders', OrderApiController::class);
    Route::apiResource('orderitems', OrderitemApiController::class);

    Route::apiResource('shipping_addresses', ShippingAddressApiController::class);

    Route::apiResource('blogs', BlogApiController::class)->except(['index']);

    Route::apiResource('checkout', CheckoutApiController::class);
    Route::post('/checkout/select-address', [CheckoutApiController::class, 'selectAddress'])->name('checkout.selectAddress');
    Route::post('/checkout/confirm-order', [CheckoutApiController::class, 'confirmOrder'])->name('checkout.confirmOrder');
});

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');