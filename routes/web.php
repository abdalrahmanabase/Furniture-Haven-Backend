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
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashbourdController;




Route::get('/test',[TestController::class,'index'])->name('home');
Route::get('/',[DashbourdController::class,'index'])->name('OverView');
Route::get('users', [DashbourdController::class,'getallusers'])->name('getusers');
Route::get('orders', [DashbourdController::class,'getallorders'])->name('getorders');


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
Route::resource('blogs', BlogController::class);

Route::resource('checkout', CheckoutController::class);
Route::post('/checkout/select-address', [CheckoutController::class, 'selectAddress'])->name('checkout.selectAddress');
Route::post('/checkout/confirm-order', [CheckoutController::class, 'confirmOrder'])->name('checkout.confirmOrder');


Route::get('register', [AuthViewController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthViewController::class, 'register']);
Route::get('login', [AuthViewController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthViewController::class, 'login']);
Route::post('logout', [AuthViewController::class, 'logout'])->name('logout');
