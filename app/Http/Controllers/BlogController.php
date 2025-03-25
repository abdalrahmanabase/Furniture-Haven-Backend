<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        $categories = Category::all();
        return view('blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to create a blog.');
        }
        $categories = Category::all();
        return view('blogs.create', compact('categories'));
    }

    public function edit(Blog $blog)
    {
        if (!Auth::check() || Auth::id() !== $blog->user_id) {
            return redirect()->route('blogs.index')->with('error', 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to create a blog.');
        }
    
        $request->validate([
            'title' => 'required|string|unique:blogs,title',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public'); // ✅ Stores in storage/app/public/blogs
        }
    
        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath, // ✅ Saves path like blogs/image.jpg
            'user_id' => Auth::id(),
        ]);
    
        return redirect()->route('blogs.index')->with('success', 'Blog added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $categories = Category::all();
        return view('blogs.show', compact('categories', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Blog $blog)
    {
        if (!Auth::check() || Auth::id() !== $blog->user_id) {
            return redirect()->route('blogs.index')->with('error', 'Unauthorized action.');
        }
    
        $request->validate([
            'title' => 'required|string|unique:blogs,title,' . $blog->id,
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);
    
        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image); // ✅ Deletes old image
            }
            $blog->image = $request->file('image')->store('blogs', 'public'); // ✅ Stores new image
        }
    
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $blog->image,
        ]);
    
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if (!Auth::check() || Auth::id() !== $blog->user_id) {
            return redirect()->route('blogs.index')->with('error', 'Unauthorized action.');
        }

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
