@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Images</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Rate</th>
                <th>Stock</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    
                    <td>
                        @if ($product->images)
                            <div class="d-flex flex-wrap">
                                @foreach ($product->images as $image)
                                    <div class="m-1">
                                        <img src="{{ asset('storage/' . $image->image) }}" width="120" class="rounded border" alt="Product Image">
                                        <div class="d-flex">
                                            @if ($image->thumbnail1)
                                                <img src="{{ asset('storage/' . $image->thumbnail1) }}" width="50" class="rounded border m-1" alt="Thumbnail 1">
                                            @endif
                                            @if ($image->thumbnail2)
                                                <img src="{{ asset('storage/' . $image->thumbnail2) }}" width="50" class="rounded border m-1" alt="Thumbnail 2">
                                            @endif
                                            @if ($image->thumbnail3)
                                                <img src="{{ asset('storage/' . $image->thumbnail3) }}" width="50" class="rounded border m-1" alt="Thumbnail 3">
                                            @endif
                                            @if ($image->thumbnail4)
                                                <img src="{{ asset('storage/' . $image->thumbnail4) }}" width="50" class="rounded border m-1" alt="Thumbnail 4">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No images available</p>
                        @endif
                    </td>

                    <td>{{ $product->title }}</td>
                    <td>{{ Str::limit($product->description, 50) }}</td> <!-- Limits description length -->
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->discount ? $product->discount . '%' : 'No discount' }}</td>
                    <td>{{ $product->rate ?? 'N/A' }}</td>
                    <td>{{ $product->stock ?? 'Out of stock' }}</td>
                    <td>{{ optional($product->category)->name ?? 'No Category' }}</td>
                    <td>
                        @if ($product->brand && $product->brand->{'logo-url'})
                            <img src="{{ asset('storage/' . $product->brand->{'logo-url'}) }}" alt="Brand Logo" width="20">
                            {{ $product->brand->name }}
                        @else
                            <span class="text-muted">No Brand</span>
                        @endif
                    </td>
                    
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
