@extends('layouts.app')

@section('title', 'Login - Learn Islam')

@section('content')
<div class="max-w-md mx-auto px-4">
    <div class="card">
        <div class="p-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Welcome Back</h2>
            <p class="text-center text-gray-600 mb-6">Login to continue your Islamic learning journey</p>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                           class="input-field @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required 
                           class="input-field @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-green-600 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                </div>

                <button type="submit" class="w-full btn-primary">
                    Login
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold">Register here</a>
            </p>
        </div>
    </div>
</div>
@endsection