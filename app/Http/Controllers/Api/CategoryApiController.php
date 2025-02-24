<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        // Fetch all category from the database
        $categories = Category::all();

        // Return category as a JSON response
        return response()->json($categories);
    }
    public function show($id)
    {
        // Find the product by its ID
        $category = Category::find($id);

        // Check if the product exists
        if (!$category) {
            // Return a 404 response if the product is not found
            return response()->json([
                'message' => 'category not found',
            ], 404);
        }

        // Return the product as a JSON response
        return response()->json($category);
    }
}
