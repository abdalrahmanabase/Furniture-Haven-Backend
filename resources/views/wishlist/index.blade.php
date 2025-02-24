@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Wishlist</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(!$wishlist || $wishlist->wishlistItems->isEmpty())
        <p class="text-muted">Your wishlist is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wishlist->wishlistItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $item->product->image) }}" width="50" alt="{{ $item->product->title }}">
                        </td>
                        <td>
                            <form action="{{ route('wishlistitems.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
