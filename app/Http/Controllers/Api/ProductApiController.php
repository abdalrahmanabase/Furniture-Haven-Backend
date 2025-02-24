<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Return products as a JSON response
        return response()->json($products);
    }

    public function show($id)
    {
        // Find the product by its ID
        $product = Product::find($id);

        // Check if the product exists
        if (!$product) {
            // Return a 404 response if the product is not found
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        // Return the product as a JSON response
        return response()->json($product);
    }
}
