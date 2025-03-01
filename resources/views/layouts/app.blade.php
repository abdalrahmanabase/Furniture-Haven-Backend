<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
{{-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('dashbourd')}}">Dashbourd</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('getusers')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('getorders')}}">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('products.index')}}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('blogs.index')}}">Blogs</a>
            </li>
        </ul>
    </div>
    </div>
</nav> --}}
<div class="maincontinar">
    <div class="sidebar">
        <div class="sidebarbrand">
            <h2>Admin Panel</h2>
        </div>
        <ul>
            <li><div class="li"> <a href="{{route('OverView')}}"><i class="fa-solid fa-house"></i>Over View</a></div></li>
            <li><div class="li"><a href="{{route('users')}}"><i class="fa-solid fa-users"></i>Users</a></div></li>
            <li><div class="li"><a href="{{route('orders')}}"><i class="fa-solid fa-folder-open"></i>Orders</a></div></li>
            <li><div class="li"><a href="{{route('products.index')}}"><i class="fa-solid fa-list"></i>Products</a></div></li>
            <li><div class="li"><a href="{{route('blogs.index')}}"><i class="fa-solid fa-blog"></i>Blogs</a></div></li>
            <li><div class="li"><a href="{{route('categories.index')}}"><i class="fas fa-folder"></i>Categories</a></div></li>
            <li><div class="li"><a href="{{route('brands.index')}}"><i class="fa-solid fa-star"></i>Brands</a></div></li>
        </ul>
    </div>

    <div class="contentmain">
            <nav>
                <div class="navdiv1">
                    <h3>Hello {{ Auth::user()->user_name }}</h3>
                    <span>Dashbourd / </span>
                    <p>{{Route::currentRouteName()}}</p>
                </div>
                <div class="navdiv2">
                    <i class="fa-regular fa-bell"></i>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
            </nav>
        @yield('content')
    </div>
</div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
