@extends ('layouts.app')

@section('title','Edit Brand')

@section('content')
    <div class="container">
        <h2>Edit Brand</h2>
        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $brand->name }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Brand Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                @if($brand->{'logo-url'})
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $brand->{'logo-url'}) }}" alt="Brand Image" width="100" height="100">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-warning">Update Brand</button>
        </form>
    </div>
@endsection
