@extends('layouts.app')

@section('title', 'Welcome - Learn Islam')

@section('content')
<div class="relative overflow-hidden">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-green-600 via-emerald-600 to-teal-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in">
                    Learn Islam Online
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-green-100 max-w-3xl mx-auto">
                    Access authentic Islamic knowledge through high-quality videos on Quran recitation, Hadith, and Islamic teachings
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-white text-green-700 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-green-50 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                        Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-green-800 transition-all duration-300 border-2 border-white">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-12">Why Choose Learn Islam?</h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Authentic Content</h3>
                <p class="text-gray-600">Learn from verified Islamic scholars and authentic sources</p>
            </div>

            <!-- Feature 2 -->
            <div class="card p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">HD Video Quality</h3>
                <p class="text-gray-600">Watch crystal clear videos with excellent audio quality</p>
            </div>

            <!-- Feature 3 -->
            <div class="card p-6 text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Learn Anytime</h3>
                <p class="text-gray-600">Access content 24/7 at your own pace and convenience</p>
            </div>
        </div>
    </div>

    <!-- Membership Plans -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold text-center text-gray-800 mb-4">Choose Your Plan</h2>
            <p class="text-center text-gray-600 mb-12">Start your Islamic learning journey today</p>
            
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Free Plan -->
                <div class="card p-8">
                    <div class="text-center mb-6">
                        <span class="bg-gray-200 text-gray-700 px-4 py-1 rounded-full text-sm font-bold">FREE</span>
                        <h3 class="text-3xl font-bold text-gray-800 mt-4">Free Membership</h3>
                        <p class="text-gray-600 mt-2">Perfect for getting started</p>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Access to free videos
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Basic Islamic content
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Community support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-secondary w-full text-center block">
                        Start Free
                    </a>
                </div>

                <!-- Premium Plan -->
                <div class="card p-8 border-4 border-yellow-400 relative">
                    <div class="absolute top-0 right-0 bg-yellow-400 text-yellow-900 px-4 py-1 rounded-bl-lg font-bold text-sm">
                        POPULAR
                    </div>
                    <div class="text-center mb-6">
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-400 text-yellow-900 px-4 py-1 rounded-full text-sm font-bold">PREMIUM</span>
                        <h3 class="text-3xl font-bold text-gray-800 mt-4">Premium Membership</h3>
                        <p class="text-gray-600 mt-2">Full access to all content</p>
                    </div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <strong>All free content included</strong>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Access to premium videos
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Exclusive Islamic lectures
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Priority support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-primary w-full text-center block">
                        Get Premium
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection