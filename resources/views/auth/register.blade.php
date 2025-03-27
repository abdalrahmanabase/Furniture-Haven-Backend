<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture-Haven Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <style>
        .required-star { color: red; margin-left: 5px; }
    </style>
</head>
<body class="bg-gray-100">

<div class="max-w-lg mx-auto mt-10 bg-white p-8 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-center">Register</h2>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Name <span class="required-star">*</span></label>
            <input type="text" name="user_name" class="w-full px-4 py-2 border rounded-lg @error('user_name') border-red-500 @enderror" value="{{ old('user_name') }}" required>
            @error('user_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Email <span class="required-star">*</span></label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Password <span class="required-star">*</span></label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg @error('password') border-red-500 @enderror" required>
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Confirm Password <span class="required-star">*</span></label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg @error('password_confirmation') border-red-500 @enderror" required>
            @error('password_confirmation')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
            Register
        </button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
</body>
</html>
