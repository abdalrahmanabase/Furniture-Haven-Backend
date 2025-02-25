<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index()
    {
        // Fetch all products with category and brand names
        $products = Product::with(['category:id,name', 'brand:id,name'])->get();

        return response()->json($products);
    }

    public function show($id)
    {
        // Find the product with category and brand names
        $product = Product::with(['category:id,name', 'brand:id,name'])->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json($product);
    }
}
