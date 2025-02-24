<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\AuthViewController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistItemController;
use App\Http\Controllers\ShippingAddressController;




Route::get('/',[TestController::class,'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('brands', BrandController::class);
Route::resource('products', ProductController::class);
Route::resource('carts', CartController::class);
Route::resource('cartitems', CartItemController::class);
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
Route::resource('wishlist', WishlistController::class)->middleware('auth');
Route::resource('wishlistitems', WishlistItemController::class)->middleware('auth');
Route::post('/wishlist/add/{productId}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add')->middleware('auth');
Route::resource('order', OrderController::class);
Route::resource('orderitem', OrderItemController::class);
Route::resource('shipping_addresses', ShippingAddressController::class);


Route::get('register', [AuthViewController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthViewController::class, 'register']);
Route::get('login', [AuthViewController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthViewController::class, 'login']);
Route::post('logout', [AuthViewController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::resource('products.images', ProductImageController::class)->except(['index', 'show']);
//     Route::get('products/{productId}/images/create', [ProductImageController::class, 'create'])->name('productimages.create');
//     Route::post('products/{productId}/images', [ProductImageController::class, 'store'])->name('productimages.store');
//     Route::delete('products/{productId}/images/{imageId}', [ProductImageController::class, 'destroy'])->name('productimages.destroy');
// });
