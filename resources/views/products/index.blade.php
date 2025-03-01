@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
    {{-- Error Message --}}
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Display Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <h2 class="mb-4">Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Product Image -->
                    @if ($product->images && count($product->images) > 0)
                    <a href="{{route('products.show',$product->id)}}"> <img src="{{ asset('storage/' . $product->images[0]->image) }}" class="card-img-top" alt="Product Image"></a>
                    @else
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="No Image">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title"><a href="{{route('products.show',$product->id)}}">{{ $product->title }}</a> </h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 60) }}</p>
                        <p class="fw-bold">${{ number_format($product->price, 2) }} 
                            @if ($product->discount)
                                <span class="badge bg-success">{{ $product->discount }}% Off</span>
                            @endif
                        </p>
                        <p class="text-muted">Stock: {{ $product->stock ?? 'Out of stock' }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- End of col-md-4 -->
        @endforeach
    </div> <!-- End of row -->
</div>
@endsection
