@extends ('layouts.app')

@section('title','Add New Category')


@section('content')
    <div class="container">
        <h2>Add New Category</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name"  class="form-label"> Category Name</label>
             


                 <input type="text" class="form-control" id="name" name="name" required>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
            </div>

            <button type="submit" class="btn btn-success">Add Category</button>
        </form>
    </div>
@endsection

