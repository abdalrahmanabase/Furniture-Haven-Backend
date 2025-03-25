<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('brands.create');
    }
    public function store(Request $request)
    {
        // التحقق من البيانات المُدخلة
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // التحقق من وجود صورة
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
        }

        // إضافة العلامة التجارية إلى قاعدة البيانات
        Brand::create([
            'name' => $validated['name'],
            'logo-url' => $imagePath ?? null,
        ]);

        // إعادة التوجيه إلى صفحة المؤشر مع رسالة نجاح
        return redirect()->route('brands.index')->with('success', 'Brand added successfully');
    }

    public function edit($id){
        $brand =Brand::findorFail($id);
        return view('brands.edit', compact('brand'));
    }
    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validate image
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;

        // Check if an image is uploaded
        if ($request->hasFile('image')) {
            // Store the new image
            $imagePath = $request->file('image')->store('brands', 'public');

            // Delete the old image (optional, if you want to remove the old file)
            if ($brand->{'logo-url'}) {
                Storage::disk('public')->delete($brand->{'logo-url'});
            }

            // Update the database with the new image path
            $brand->{'logo-url'} = $imagePath;
        }

        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully!');
    }
}
