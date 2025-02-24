@extends('layouts.app') <!-- Assuming you have a master layout -->

@section('content')
<div class="container">
    <h1 class="my-4">Your Orders</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="alert alert-info">
            You have no orders yet.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <span class="badge
                                    @if ($order->status == 'pending') badge-warning
                                    @elseif ($order->status == 'processing') badge-info
                                    @elseif ($order->status == 'shipped') badge-primary
                                    @elseif ($order->status == 'delivered') badge-success
                                    @elseif ($order->status == 'cancelled') badge-danger
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
