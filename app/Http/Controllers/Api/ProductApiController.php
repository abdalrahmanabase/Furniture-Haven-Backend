<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index()
    {
        // Fetch products with related category, brand, and images
        $products = Product::with(['category:id,name', 'brand:id,name', 'images'])->get();

        // Convert image paths to full URLs
        $products->transform(function ($product) {
            if ($product->images) {
                $product->images->transform(function ($image) {
                    $image->image = $image->image ? url('storage/' . $image->image) : null;
                    $image->thumbnail1 = $image->thumbnail1 ? url('storage/' . $image->thumbnail1) : null;
                    $image->thumbnail2 = $image->thumbnail2 ? url('storage/' . $image->thumbnail2) : null;
                    $image->thumbnail3 = $image->thumbnail3 ? url('storage/' . $image->thumbnail3) : null;
                    $image->thumbnail4 = $image->thumbnail4 ? url('storage/' . $image->thumbnail4) : null;
                    return $image;
                });
            }
            return $product;
        });

        return response()->json(['products' => $products]);
    }

    public function show($id)
    {
        // Fetch a single product with category, brand, and images
        $product = Product::with(['category:id,name', 'brand:id,name', 'images'])->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // Convert image paths to full URLs
        if ($product->images) {
            $product->images->transform(function ($image) {
                $image->image = $image->image ? url('storage/' . $image->image) : null;
                $image->thumbnail1 = $image->thumbnail1 ? url('storage/' . $image->thumbnail1) : null;
                $image->thumbnail2 = $image->thumbnail2 ? url('storage/' . $image->thumbnail2) : null;
                $image->thumbnail3 = $image->thumbnail3 ? url('storage/' . $image->thumbnail3) : null;
                $image->thumbnail4 = $image->thumbnail4 ? url('storage/' . $image->thumbnail4) : null;
                return $image;
            });
        }

        return response()->json([
            'product' => $product
        ]);
    }
}