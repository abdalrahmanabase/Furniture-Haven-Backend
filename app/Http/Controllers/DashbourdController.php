<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Blog;
use App\Models\User;
use Carbon\Carbon;


class DashbourdController extends Controller
{
    public function index(){
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to add items to the wishlist.');
        }
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $orders = Order::all();
        $blogs = Blog::all();
        $users = User::all();
        $totalCustomers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalBlogs = Blog::count();

        // Fetch sales data grouped by month
        $salesData = Order::selectRaw('SUM(total_price) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fetch user registrations grouped by month
        $userData = User::selectRaw('COUNT(id) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fetch all users with last login and order count
        $usersdal = User::select('id', 'user_name', 'email')
            ->withCount('orders') // Count total orders per user
            ->get()
            ->map(function ($user) {
                $lastSession = DB::table('sessions')
                    ->where('user_id', $user->id)
                    ->orderByDesc('last_activity') // Get the most recent session
                    ->first();
                $user->last_login_at = $lastSession ? Carbon::createFromTimestamp($lastSession->last_activity) : null;
                return $user;
            });
            return view('dashbourd.dashbourd', compact(
                'totalCustomers', 'totalOrders', 'totalProducts', 'totalBlogs',
                'salesData', 'userData', 'usersdal'
            ));
    }
    
    public function getallusers(){
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to add items to the wishlist.');
        }
        $usersdal = User::select('id', 'user_name', 'email')
        ->withCount('orders') // Counts total orders per user
        ->get()
        ->map(function ($user) {
            $lastSession = DB::table('sessions')
                ->where('user_id', $user->id)
                ->orderByDesc('last_activity') // Get the most recent session
                ->first();
            $user->last_login_at = $lastSession ? \Carbon\Carbon::createFromTimestamp($lastSession->last_activity) : null;
            return $user;
        });
        $users=User::all();
        return view('dashbourd.usersdisplay',compact('users','usersdal'));
    }

    public function getallorders()
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to view orders.');
        }

        $orders = Order::with(['user', 'orderItems.product'])->get();

        return view('dashbourd.ordersdisplay', compact('orders'));
    }
}
