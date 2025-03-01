@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Title with Icon -->
    <h2 class="mb-4">
        <i class="fas fa-tags"></i> Categories
    </h2>

    <!-- Add New Category Button -->
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle"></i> Add New Category
    </a>

    <!-- Categories Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-tag"></i> Name</th>
                        <th><i class="fas fa-cogs"></i> Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <i class="fas fa-folder-open text-primary"></i> 
                                {{ $category->name }}
                            </td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
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
