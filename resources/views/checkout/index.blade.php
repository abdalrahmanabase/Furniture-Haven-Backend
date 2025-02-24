@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        {{-- Error Message --}}
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Address Selection -->
    <h3>Select Shipping Address</h3>
    <form action="{{ route('checkout.selectAddress') }}" method="POST">
        @csrf
        <a href="{{route('shipping_addresses.create')}}">Add</a>
        @foreach($addresses as $address)
            <div class="form-check">
                <input class="form-check-input" type="radio" name="shipping_address_id" value="{{ $address->id }}"
                    @if(session('selected_address_id') == $address->id) checked @endif>
                <label class="form-check-label">
                    {{ $address->first_name }} {{ $address->last_name }}, {{ $address->address_line1 }}, {{ $address->city }}, {{ $address->country }}
                    <br> Phone: {{ $address->phone_number }}
                </label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary mt-2">Confirm Address</button>
    </form>

    <!-- Display Selected Address -->
    @if($selectedAddress)
        <h4>Selected Address:</h4>
        <p>{{ $selectedAddress->first_name }} {{ $selectedAddress->last_name }}</p>
        <p>{{ $selectedAddress->address_line1 }}, {{ $selectedAddress->city }}, {{ $selectedAddress->country }}</p>
        <p>Phone: {{ $selectedAddress->phone_number }}</p>
    @endif

    <!-- Cart Items -->
    <h3>Cart Items</h3>
    @if($cartItems->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->product->price * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('checkout.confirmOrder') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Confirm Order</button>
        </form>
    @else
        <p>Your cart is empty.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Shop Now</a>
    @endif
</div>
@endsection
