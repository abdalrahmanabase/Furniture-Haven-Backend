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
            'stock' => 'nullable|numeric',
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

        $imagePath = $request->file('image')->store('product_images', 'public');

        $thumbnails = [];
        foreach (['thumbnail1', 'thumbnail2', 'thumbnail3', 'thumbnail4'] as $thumb) {
            if ($request->hasFile($thumb)) {
                $thumbnails[$thumb] = $request->file($thumb)->store('product_images/thumbnails', 'public');
            }
        }

        ProductImage::create([
            'product_id' => $product->id,
            'image' => $imagePath,
            'thumbnail1' => $thumbnails['thumbnail1'] ?? null,
            'thumbnail2' => $thumbnails['thumbnail2'] ?? null,
            'thumbnail3' => $thumbnails['thumbnail3'] ?? null,
            'thumbnail4' => $thumbnails['thumbnail4'] ?? null,
        ]);

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
            'stock' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail1' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'thumbnail4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $product->update($request->only([
            'title', 'description', 'price', 'discount', 'rate', 'stock', 'category_id', 'brand_id'
        ]));

        $productImage = $product->images()->first();

        if (!$productImage) {
            $productImage = new ProductImage(['product_id' => $product->id]);
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($productImage->image);
            $productImage->image = $request->file('image')->store('product_images', 'public');
        }

        foreach (['thumbnail1', 'thumbnail2', 'thumbnail3', 'thumbnail4'] as $thumb) {
            if ($request->hasFile($thumb)) {
                Storage::disk('public')->delete($productImage->$thumb);
                $productImage->$thumb = $request->file($thumb)->store('product_images/thumbnails', 'public');
            }
        }

        $productImage->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully with images!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
