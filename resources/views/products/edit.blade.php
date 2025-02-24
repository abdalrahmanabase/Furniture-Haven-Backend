@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required value="{{ $product->title }}">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required value="{{ $product->price }}">
            @error('price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="discount">Discount</label>
            <input type="number" name="discount" id="discount" class="form-control" step="0.01" value="{{ $product->discount }}">
            @error('discount')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="rate">Rate</label>
            <input type="number" name="rate" id="rate" class="form-control" step="0.1" value="{{ $product->rate }}">
            @error('rate')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control"  value="{{ $product->stock }}">
            @error('stock')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror  
        </div>

        <div class="form-group">
            <label for="brand_id">Brand</label>
            <select name="brand_id" id="brand_id" class="form-control" required>
                <option value="">Select a Brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Main Product Image:</label>
            <input type="file" name="image" class="form-control">
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Thumbnail 1:</label>
            <input type="file" name="thumbnail1" class="form-control">
            @error('thumbnail1')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Thumbnail 2:</label>
            <input type="file" name="thumbnail2" class="form-control">
            @error('thumbnail2')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Thumbnail 3:</label>
            <input type="file" name="thumbnail3" class="form-control">
            @error('thumbnail3')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Thumbnail 4:</label>
            <input type="file" name="thumbnail4" class="form-control">
            @error('thumbnail4')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
