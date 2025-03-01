@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 p-4">
        <div class="row">
            <!-- Product Image Section -->
            <div class="col-md-6 text-center">
                @if ($product->images && count($product->images) > 0)
                    <img src="{{ asset('storage/' . $product->images[0]->image) }}" 
                         alt="Product Image" 
                         class="img-fluid rounded shadow-lg border" 
                         style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/400" 
                         alt="No Image Available" 
                         class="img-fluid rounded shadow-lg border">
                @endif
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h1 class="fw-bold mb-3">{{ $product->title }}</h1>
                <p class="text-muted"><strong>Category:</strong> {{ optional($product->category)->name ?? 'No Category' }}</p>
                <p><strong>Brand:</strong> {{ optional($product->brand)->name ?? 'No Brand' }}</p>

                <h3 class="text-success mt-3">${{ number_format($product->price, 2) }}</h3>
                @if ($product->discount)
                    <span class="badge bg-danger fs-6">{{ $product->discount }}% Off</span>
                @endif

                <p class="mt-2"><strong>Stock:</strong> 
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </p>

                <p class="text-muted"><strong>Rating:</strong> ⭐ {{ $product->rate ?? 'N/A' }}</p>
                <p class="text-muted"><strong>Description:</strong> {{ $product->description }}</p>

                <!-- Thumbnails -->
                @if ($product->images && count($product->images) > 0)
                    <h5 class="mt-4">Thumbnails</h5>
                    <div class="d-flex flex-wrap">
                        @foreach ($product->images as $image)
                            @foreach (['thumbnail1', 'thumbnail2', 'thumbnail3', 'thumbnail4'] as $thumb)
                                @if($image->$thumb)
                                    <img src="{{ asset('storage/' . $image->$thumb) }}" 
                                         alt="Thumbnail" 
                                         class="border rounded m-1" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
