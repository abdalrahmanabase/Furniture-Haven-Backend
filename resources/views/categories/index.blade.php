@extends ('layouts.app')
@section('content')
<div class="container">
    <h2>Categories</h2>
    <a href="{{route('categories.create')}}" class="btn btn-primary">Add New Categories</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr >
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>
                    <a href="{{route('categories.edit', $category->id)}}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{route('categories.destroy', $category->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
