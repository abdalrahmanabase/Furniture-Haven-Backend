@extends('layouts.app')
@section('content')

<div class="continarcontent">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
    {{-- Error Message --}}
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="firstcards">
        <div class="firstcard2">
            <h2>Total Users</h2>
            <span>{{$totalCustomers}}</span>
        </div>
        <div class="firstcard">
            <h2>Orders</h2>
            <span>{{$totalOrders}}</span>
        </div>
        <div class="firstcard2">
            <h2>Products</h2>
            <span>{{$totalProducts}}</span>
        </div>
        <div class="firstcard">
            <h2>Blogs</h2>
            <span>{{$totalBlogs}}</span>
        </div>
    </div>
    <div class="buttons">
        <button id="salesBtn" class="active">Sales Chart</button>
        <button id="usersBtn">Users Chart</button>
    </div>

    <div class="chart-container">
        <canvas id="salesChart"></canvas>
        <canvas id="usersChart" style="display: none;"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var salesCtx = document.getElementById("salesChart").getContext("2d");
            var usersCtx = document.getElementById("usersChart").getContext("2d");

            // Sales Chart
            var salesChart = new Chart(salesCtx, {
                type: "line",
                data: {
                    labels: @json($salesData->pluck('month')),
                    datasets: [{
                        label: "Total Sales",
                        data: @json($salesData->pluck('total')),
                        borderColor: "#86b7fe",
                        backgroundColor: "rgba(155, 81, 224, 0.2)",
                        borderWidth: 3,
                        pointBackgroundColor: "white",
                        pointBorderColor: "#86b7fe",
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Users Chart
            var usersChart = new Chart(usersCtx, {
                type: "line",
                data: {
                    labels: @json($userData->pluck('month')),
                    datasets: [{
                        label: "New Users",
                        data: @json($userData->pluck('count')),
                        borderColor: "#56CCF2",
                        backgroundColor: "rgba(86, 204, 242, 0.2)",
                        borderWidth: 3,
                        pointBackgroundColor: "white",
                        pointBorderColor: "#56CCF2",
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

            // Toggle Charts
            document.getElementById("salesBtn").addEventListener("click", function () {
                document.getElementById("salesChart").style.display = "block";
                document.getElementById("usersChart").style.display = "none";
                this.classList.add("active");
                document.getElementById("usersBtn").classList.remove("active");
            });

            document.getElementById("usersBtn").addEventListener("click", function () {
                document.getElementById("salesChart").style.display = "none";
                document.getElementById("usersChart").style.display = "block";
                this.classList.add("active");
                document.getElementById("salesBtn").classList.remove("active");
            });
        });
    </script>

<div class="usersdis">
    <h2>All Users</h2>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Last Active</th>
                <th>Orders Made</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usersdal as $user)
                <tr>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
                    <td>{{ $user->orders_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

@endsection