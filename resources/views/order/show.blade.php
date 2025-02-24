@extends('layouts.app') <!-- Assuming you have a master layout -->

@section('content')
<div class="container">
    <h1 class="my-4">Order Details</h1>

    <div class="card">
        <div class="card-header">
            <h5>Order #{{ $order->id }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        <span class="badge
                            @if ($order->status == 'pending') badge-warning
                            @elseif ($order->status == 'processing') badge-info
                            @elseif ($order->status == 'shipped') badge-primary
                            @elseif ($order->status == 'delivered') badge-success
                            @elseif ($order->status == 'cancelled') badge-danger
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                    <p><strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}</p>
                </div>
            </div>

            <hr>

            <h5>Order Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($order->orderItems && $order->orderItems->count() > 0)
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->title ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->product->price ?? 0, 2) }}</td>
                                <td>${{ number_format(($item->quantity * ($item->product->price ?? 0)), 2) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4">No items in this order.</td>
                        </tr>
                    @endif
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('order.index') }}" class="btn btn-secondary">Back to Orders</a>
    </div>
</div>
@endsection
