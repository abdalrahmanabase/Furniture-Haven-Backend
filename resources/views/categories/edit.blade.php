@extends ('layouts.app')

@section('title','Edit Category')


@section('content')
    <div class="container">
        <h2>Edit Category</h2>
        <form action="{{ route('categories.update',$category->id) }}" method="POST">
            @csrf
@method('PUT')
            <div class="mb-3">
                <label for="name"  class="form-label"> Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}" required>
            </div>

            <button type="submit" class="btn btn-warning">Update Category</button>
        </form>
    </div>
@endsection


