@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $blog->title }}</h2>
    <p><strong>Category:</strong> {{ $blog->category->name ?? 'Uncategorized' }}</p>

    @if ($blog->image)
        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid mb-3">
    @endif

    <p>{{ $blog->content }}</p>

    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Back to Blogs</a>
    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning">Edit</a>

    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</div>
@endsection
