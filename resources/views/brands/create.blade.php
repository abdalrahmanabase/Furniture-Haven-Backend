@extends ('layouts.app')

@section('title','Add New brand')


@section('content')
    <div class="container">
        <h2>Add New Brand</h2>
        <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Brand Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
        @error('name')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Brand Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-success">Add Brand</button>
</form>

    </div>
@endsection

