@extends('layouts.app')
@section('content')

<div class="usersdis">
    <h2>All Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Email</th>
                <th>Products</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->user_name }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>
                        <ul>
                            @foreach($order->orderItems as $item)
                                <li>{{ $item->product->name }} (x{{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>${{ number_format($order->total_price, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection