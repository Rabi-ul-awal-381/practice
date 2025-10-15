@extends('layouts.app')

@section('title', 'Register - Learn Islam')

@section('content')
<div class="max-w-md mx-auto px-4">
    <div class="card">
        <div class="p-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">Create Account</h2>
            <p class="text-center text-gray-600 mb-6">Join our Islamic learning community</p>

            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                           class="input-field @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                           class="input-field">
                </div>

                <!-- Membership Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Choose Membership</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition">
                            <input type="radio" name="membership_type" value="free" checked class="w-4 h-4 text-green-600">
                            <div class="ml-3">
                                <span class="font-semibold text-gray-800">Free Membership</span>
                                <p class="text-sm text-gray-600">Access to free Islamic videos</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-yellow-400 rounded-lg cursor-pointer hover:border-yellow-500 transition bg-yellow-50">
                            <input type="radio" name="membership_type" value="paid" class="w-4 h-4 text-yellow-600">
                            <div class="ml-3">
                                <span class="font-semibold text-gray-800 flex items-center">
                                    Premium Membership
                                    <span class="ml-2 bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full text-xs">RECOMMENDED</span>
                                </span>
                                <p class="text-sm text-gray-600">Access to all premium Islamic content</p>
                            </div>
                        </label>
                    </div>
                    @error('membership_type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-primary">
                    Create Account
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold">Login here</a>
            </p>
        </div>
    </div>
</div>
@endsection