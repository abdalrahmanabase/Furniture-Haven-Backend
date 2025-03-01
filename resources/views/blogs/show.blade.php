@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <!-- Blog Title -->
            <h1 class="text-center font-weight-bold mb-3">{{ $blog->title }}</h1>
            
            <!-- Category Badge -->
            <p class="text-center">
                <span class="badge bg-primary text-white px-3 py-2">
                    {{ $blog->category->name ?? 'Uncategorized' }}
                </span>
            </p>

            <!-- Author Name -->
            <p class="text-center text-muted">
                <strong>By:</strong> {{ $blog->user->user_name ?? 'Unknown Author' }} 
                <span class="mx-2">|</span>
                <strong>Published on:</strong> {{ $blog->created_at->format('M d, Y') }}
            </p>

            <!-- Blog Image -->
            @if ($blog->image)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $blog->image) }}" 
                         alt="{{ $blog->title }}" 
                         class="img-fluid rounded shadow" 
                         style="max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <!-- Blog Content -->
            <div class="content">
                <p class="lead text-justify">{{ $blog->content }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Blogs
                </a>
                <div>
                    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
