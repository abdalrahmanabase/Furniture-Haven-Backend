@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Shipping Address</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('shipping_addresses.update', $shippingAddress->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                   value="{{ old('first_name', $shippingAddress->first_name) }}" required>
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                   value="{{ old('last_name', $shippingAddress->last_name) }}" required>
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address_line1" class="form-label">Address Line 1</label>
            <input type="text" name="address_line1" id="address_line1" class="form-control @error('address_line1') is-invalid @enderror" 
                   value="{{ old('address_line1', $shippingAddress->address_line1) }}" required>
            @error('address_line1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address_line2" class="form-label">Address Line 2 (Optional)</label>
            <input type="text" name="address_line2" id="address_line2" class="form-control @error('address_line2') is-invalid @enderror" 
                   value="{{ old('address_line2', $shippingAddress->address_line2) }}">
            @error('address_line2')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" 
                   value="{{ old('city', $shippingAddress->city) }}" required>
            @error('city')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="state" class="form-label">State (Optional)</label>
            <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror" 
                   value="{{ old('state', $shippingAddress->state) }}">
            @error('state')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control @error('zip_code') is-invalid @enderror" 
                   value="{{ old('zip_code', $shippingAddress->zip_code) }}">
            @error('zip_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror" 
                   value="{{ old('country', $shippingAddress->country) }}" required>
            @error('country')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                   value="{{ old('phone_number', $shippingAddress->phone_number) }}" required>
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="google_map_link" class="form-label">Google Map Link (Optional)</label>
            <input type="url" name="google_map_link" id="google_map_link" class="form-control @error('google_map_link') is-invalid @enderror" 
                   value="{{ old('google_map_link', $shippingAddress->google_map_link) }}">
            @error('google_map_link')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Address</button>
    </form>
</div>
@endsection
