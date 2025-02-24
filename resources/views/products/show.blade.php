@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">{{ $product->title }}</h1>

    <div class="mb-4">
        <img src="{{ asset('storage/' . $product->images->image) }}" alt="Product Image" class="w-64 h-64 object-cover">
    </div>

    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
    <p><strong>Discount:</strong> {{ $product->discount }}%</p>
    <p><strong>Rate:</strong> {{ $product->rate }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <p><strong>Category:</strong> {{ $product->category->name }}</p>
    <p><strong>Brand:</strong> {{ $product->brand->name }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>

    <h3 class="mt-4 font-semibold">Thumbnails</h3>
    <div class="flex space-x-2">
        @foreach(['thumbnail1', 'thumbnail2', 'thumbnail3', 'thumbnail4'] as $thumb)
            @if($product->images->$thumb)
                <img src="{{ asset('storage/' . $product->images->$thumb) }}" alt="Thumbnail" class="w-24 h-24 object-cover">
            @endif
        @endforeach
    </div>

    <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">Back to Products</a>
    <a href="{{ route('products.edit', $product->id) }}" class="mt-4 inline-block bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
</div>
@endsection
