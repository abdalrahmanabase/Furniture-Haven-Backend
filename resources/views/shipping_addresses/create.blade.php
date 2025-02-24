@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Shipping Address</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shipping_addresses.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address_line1" class="form-label">Address Line 1</label>
            <input type="text" name="address_line1" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address_line2" class="form-label">Address Line 2 (Optional)</label>
            <input type="text" name="address_line2" class="form-control">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="state" class="form-label">State (Optional)</label>
            <input type="text" name="state" class="form-control">
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" name="country" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code</label>
            <input type="text" name="zip_code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="google_map_link" class="form-label">Google Map Link (Optional)</label>
            <input type="url" name="google_map_link" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Address</button>
        <a href="{{ route('shipping_addresses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection