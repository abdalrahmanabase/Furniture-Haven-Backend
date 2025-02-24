@extends ('layouts.app')

@section('content')
<div class="container">
    <h2>Brands</h2>
    <a href="{{ route('brands.create') }}" class="btn btn-primary">Add New Brand</a>
    <table class="table mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($brands as $brand)
        <tr>
            <td>{{ $brand->id }}</td>
            <td>{{ $brand->name }}</td>
            <td>
                @if($brand->{'logo-url'})
                    <img src="{{ asset('storage/' . $brand->{'logo-url'}) }}" width="100" alt="Brand Image">
                @else
                    No Image
                @endif
            </td>

            <td>
                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
