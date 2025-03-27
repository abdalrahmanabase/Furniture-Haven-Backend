<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get(); 
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.create', compact('categories', 'brands'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    public function show(Product $product)
    {
        $product->load('images');
        return view('products.show', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'rate' => 'nullable|numeric',
            'stock' => 'required|integer|min:0', // Stock is now required
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'thumbnail1' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $product = Product::create($request->only([
            'title', 'description', 'price', 'discount', 'rate', 'stock', 'category_id', 'brand_id'
        ]));
    
        return redirect()->route('products.index')->with('success', 'Product created successfully with images!');
    }
    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'rate' => 'nullable|numeric',
            'stock' => 'required|integer|min:0', // Stock is now required
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);
    
        $product->update($request->only([
            'title', 'description', 'price', 'discount', 'rate', 'stock', 'category_id', 'brand_id'
        ]));
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0', // Ensure stock is required
        ]);
    
        $product->update(['stock' => $request->stock]);
    
        return response()->json(['message' => 'Stock updated successfully']);
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
