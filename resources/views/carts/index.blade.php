@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Cart</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cart && $cart->cartItems->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>
                            <form action="{{ route('cartitems.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>

                            <form action="{{ route('cartitems.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
