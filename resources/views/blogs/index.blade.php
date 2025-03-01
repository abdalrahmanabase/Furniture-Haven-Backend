@extends('layouts.app')

@section('content')
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
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📚 All Blogs</h2>
        <a href="{{ route('blogs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Blog
        </a>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Blog Cards -->
    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg border-0 h-100">
                    @if ($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" 
                             class="card-img-top" 
                             alt="{{ $blog->title }}" 
                             style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" 
                             class="card-img-top" 
                             alt="No Image Available">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $blog->title }}</h5>
                        <p class="text-muted">
                            <strong>Category:</strong> {{ $blog->category->name ?? 'Uncategorized' }}
                        </p>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- No Blogs Message -->
    @if ($blogs->isEmpty())
        <div class="text-center mt-4">
            <h5 class="text-muted">No blogs available. Start by creating a new blog!</h5>
        </div>
    @endif
</div>
@endsection
