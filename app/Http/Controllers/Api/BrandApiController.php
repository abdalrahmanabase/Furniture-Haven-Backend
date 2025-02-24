<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
class BrandApiController extends Controller
{

    public function index()
    {
        // Fetch all brands from the database
        $brands = Brand::all();

        // Return brands as a JSON response
        return response()->json($brands);
    }

    public function show($id)
    {
        // Find the product by its ID
        $brand = Brand::find($id);

        // Check if the product exists
        if (!$brand) {
            // Return a 404 response if the product is not found
            return response()->json([
                'message' => 'brand not found',
            ], 404);
        }

        // Return the product as a JSON response
        return response()->json($brand);
    }
}
