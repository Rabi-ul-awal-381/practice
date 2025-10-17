@extends('layouts.app')

@section('title', 'Welcome - Learn Islam')

@section('content')
<section class="relative bg-gradient-to-br from-green-600 via-emerald-600 to-teal-700 text-white py-20 text-center">
    <div class="container mx-auto px-6">
        @auth
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Welcome back, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Ready to keep learning? Explore our latest videos below.
            </p>
            <a href="{{ route('videos.index') }}"
               class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-indigo-700 transition">
               🎥 View All Videos
            </a>
        @else
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Welcome to Our Learning Platform 🌙
            </h1>
            <p class="text-lg text-gray-600 mb-6 max-w-2xl mx-auto">
                Watch inspiring Quranic content, learn new lessons, and grow your understanding.
            </p>
            <div class="space-x-4">
                <a href="{{ route('login') }}" 
                   class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-indigo-700 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" 
                   class="inline-block bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold shadow hover:bg-gray-300 transition">
                    Register
                </a>
            </div>
        @endauth
    </div>
</section>


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
    <section class="relative py-20 bg-gradient-to-br from-green-600 via-emerald-600 to-teal-700  text-white">
    <div class="container mx-auto px-6 text-center">

        @guest
            <!-- Guests see Choose Your Plan -->
            <h2 class="text-4xl font-bold mb-4">Choose Your Plan</h2>
            <p class="text-lg mb-10 text-indigo-100 max-w-2xl mx-auto">
                Start learning for free or unlock premium content to deepen your understanding.
            </p>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur rounded-2xl shadow-lg p-8 hover:bg-white/20 transition">
                    <h3 class="text-2xl font-semibold mb-4">Free Plan</h3>
                    <ul class="text-indigo-100 text-left mb-6 space-y-2">
                        <li>✅ Access to selected free videos</li>
                        <li>✅ No credit card required</li>
                        <li>❌ No premium lessons</li>
                    </ul>
                    <a href="{{ route('register') }}"
                       class="inline-block bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg hover:bg-indigo-100 transition">
                       Get Started
                    </a>
                </div>

                <div class="bg-white/10 backdrop-blur rounded-2xl shadow-lg p-8 hover:bg-white/20 transition">
                    <h3 class="text-2xl font-semibold mb-4">Premium Plan</h3>
                    <ul class="text-indigo-100 text-left mb-6 space-y-2">
                        <li>✅ Unlimited access to all videos</li>
                        <li>✅ Exclusive premium categories</li>
                        <li>✅ Watch without ads</li>
                    </ul>
                    <a href="{{ route('register') }}"
                       class="inline-block bg-white text-indigo-700 font-semibold px-6 py-3 rounded-lg hover:bg-indigo-100 transition">
                       Upgrade Now
                    </a>
                </div>
            </div>

        @else
            <!-- Logged-in users see About / Welcome message -->
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-4xl font-extrabold mb-4">
                     {{ auth()->user()->name }} 🌙
                </h2>
                <p class="text-lg text-indigo-100 leading-relaxed mb-6">
                    You’re part of a growing community dedicated to learning, reflection, and understanding.  
                    Explore videos crafted to bring the Qur’an and Islamic knowledge closer to your heart.
                </p>
                <p class="text-indigo-100 mb-10">
                    Continue your journey of knowledge — may every lesson guide you toward light and wisdom.
                </p>

                <a href="{{ route('videos.index') }}"
                   class="inline-block bg-white text-indigo-700 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-100 transition shadow">
                   🎥 Explore All Videos
                </a>
            </div>
        @endguest

    </div>

    <!-- Decorative gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/10 to-black/20 pointer-events-none"></div>
</section>


@endsection