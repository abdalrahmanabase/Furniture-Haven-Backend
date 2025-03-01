@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Title with Icon -->
    <h2 class="mb-4">
        <i class="fas fa-building"></i> Brands
    </h2>

    <!-- Add New Brand Button -->
    <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle"></i> Add New Brand
    </a>

    <!-- Brands Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-tag"></i> Name</th>
                        <th><i class="fas fa-image"></i> Logo</th>
                        <th><i class="fas fa-cogs"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>
                                <i class="fas fa-trademark text-primary"></i> 
                                {{ $brand->name }}
                            </td>
                            <td>
                                @if ($brand->{'logo-url'})
                                    <img src="{{ asset('storage/' . $brand->{'logo-url'}) }}" 
                                         alt="Brand Logo" 
                                         class="border rounded" 
                                         width="80" height="50">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this brand?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
