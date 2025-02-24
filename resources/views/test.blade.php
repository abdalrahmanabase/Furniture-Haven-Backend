@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="cards">
            @foreach ($products as $product)
                <div class="card">
                    <img src="{{ asset('storage/'. $product->image) }}" alt="{{ $product->name }}">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">Add to Cart</button>
                    </form>
                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">Add to wishlist</button>
                    </form> 
                </div>
            @endforeach

        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn">Logout</button>
        </form>


    </div>
@endsection
