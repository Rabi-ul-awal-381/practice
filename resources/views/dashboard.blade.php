@extends('layouts.app')

@section('title', 'Dashboard - Learn Islam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl shadow-lg p-8 text-white mb-8">
        <h1 class="text-3xl font-bold mb-2">As-salamu alaykum, {{ auth()->user()->name }}!</h1>
        <p class="text-green-100">Welcome back to your Islamic learning journey</p>
        <div class="mt-4">
            @if(auth()->user()->isPaidMember())
                <span class="bg-yellow-400 text-yellow-900 px-4 py-2 rounded-full text-sm font-bold">
                    ⭐ PREMIUM MEMBER
                </span>
            @else
                <span class="bg-white text-green-700 px-4 py-2 rounded-full text-sm font-bold">
                    FREE MEMBER
                </span>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Videos Watched</p>
                    <p class="text-3xl font-bold text-gray-800">{{ auth()->user()->videoViews()->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Membership</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ auth()->user()->isPaidMember() ? 'Premium' : 'Free' }}
                    </p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Available Videos</p>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ $videos->count() }}+
                    </p>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::check() && Auth::user()->membership_type === 'premium')
    <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
        <h3 class="font-bold text-lg">Premium Membership</h3>

        <p>
            Membership Active From:
            {{ optional(auth()->user()->membership_start)->format('F j, Y') ?? 'N/A' }}
        </p>

        <p>
            Expires On:
            {{ optional(auth()->user()->membership_end)->format('F j, Y') ?? 'N/A' }}
        </p>
    </div>
@endif



    <!-- Recent Videos -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Continue Learning</h2>
            <a href="{{ route('videos.index') }}" class="text-green-600 hover:text-green-700 font-semibold">
                View All →
            </a>
        </div>

        @if($videos->count() > 0)
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($videos as $video)
                    <a href="{{ route('videos.show', $video) }}" class="card group">
                        <div class="relative">
                            @if($video->thumbnail)
                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                    </svg>
                                </div>
                            @endif
                            @if($video->isPaid())
                                <span class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded text-xs font-bold">
                                    PREMIUM
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-2 group-hover:text-green-600 transition">
                                {{ Str::limit($video->title, 50) }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($video->description, 80) }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                    </svg>
                                    {{ $video->category->name ?? '' }}
                                </span>
                                <span>{{ $video->views }} views</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="card p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No videos available yet</h3>
                <p class="text-gray-600">Check back soon for new Islamic content</p>
            </div>
        @endif
    </div>

    <!-- Upgrade CTA (for free members) -->
    @if(!auth()->user()->isPaidMember())
        <div class="bg-gradient-to-r from-yellow-400 to-orange-400 rounded-xl shadow-lg p-8 text-center">
            <h2 class="text-3xl font-bold text-yellow-900 mb-4">Upgrade to Premium</h2>
            <p class="text-yellow-800 mb-6">Get access to exclusive Islamic lectures, Quran recitations, and premium content</p>
            <a href="{{ route('payments.checkout') }}"
   class="bg-yellow-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-yellow-800 transition-all duration-300 shadow-lg inline-block">
   Upgrade Now
</a>

        </div>
    @endif
</div>
@endsection