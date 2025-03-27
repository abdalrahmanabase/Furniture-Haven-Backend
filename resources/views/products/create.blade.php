@extends('layouts.app')

@section('content')
<style>
    .required-field::after {
        content: " *";
        color: red;
    }
</style>

<div class="container">
    <h2 class="mb-4">Add New Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label required-field">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label required-field">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label required-field">Price ($)</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount" class="form-control" step="0.01" value="{{ old('discount') }}">
                @error('discount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="rate" class="form-label">Rate</label>
                <input type="number" name="rate" id="rate" class="form-control" step="0.1" value="{{ old('rate') }}">
                @error('rate') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="stock" class="form-label required-field">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" required value="{{ old('stock') }}">
                @error('stock') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="category_id" class="form-label required-field">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror  
            </div>

            <div class="col-md-6 mb-3">
                <label for="brand_id" class="form-label required-field">Brand</label>
                <select name="brand_id" id="brand_id" class="form-control" required>
                    <option value="">Select a Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label required-field">Main Product Image</label>
            <input type="file" name="image" class="form-control" required>
            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="thumbnail1" class="form-label">Thumbnail 1</label>
                <input type="file" name="thumbnail1" class="form-control">
                @error('thumbnail1') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="thumbnail2" class="form-label">Thumbnail 2</label>
                <input type="file" name="thumbnail2" class="form-control">
                @error('thumbnail2') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="thumbnail3" class="form-label">Thumbnail 3</label>
                <input type="file" name="thumbnail3" class="form-control">
                @error('thumbnail3') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="thumbnail4" class="form-label">Thumbnail 4</label>
                <input type="file" name="thumbnail4" class="form-control">
                @error('thumbnail4') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection