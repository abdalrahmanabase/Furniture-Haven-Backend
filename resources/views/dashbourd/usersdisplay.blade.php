@extends('layouts.app')
@section('content')

<div class="usersdis">
    <h2>Users List</h2>
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
            @foreach($usersdal as $user)
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


@endsection