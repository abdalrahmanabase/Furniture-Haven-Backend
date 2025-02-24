@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shipping Addresses</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('shipping_addresses.create') }}" class="btn btn-primary mb-3">Add New Address</a>

    @if($addresses->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($addresses as $address)
                    <tr>
                        <td>{{ $address->first_name }} {{ $address->last_name }}</td>
                        <td>{{ $address->address_line1 }}, {{ $address->address_line2 }}</td>
                        <td>{{ $address->city }}</td>
                        <td>{{ $address->country }}</td>
                        <td>
                            <a href="{{ route('shipping_addresses.edit', $address->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('shipping_addresses.destroy', $address->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No shipping addresses found.</p>
    @endif
</div>
@endsection