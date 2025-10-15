@extends('layouts.app')

@section('title', 'Videos - Learn Islam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Islamic Videos</h1>
        <p class="text-gray-600">Explore our collection of authentic Islamic content</p>
    </div>

    <!-- Category Filter -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('videos.index') }}" 
               class="px-4 py-2 rounded-lg font-medium transition {{ !$selectedCategory ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All Videos
            </a>
            @foreach($categories as $category)
                <a href="{{ route('videos.index', ['category' => $category->id]) }}" 
                   class="px-4 py-2 rounded-lg font-medium transition {{ $selectedCategory == $category->id ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ $category->name }} ({{ $category->videos_count }})
                </a>
            @endforeach
        </div>
    </div>

    <!-- Videos Grid -->
    @if($videos->count() > 0)
        <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
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
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition flex items-center justify-center">
                            <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-2 group-hover:text-green-600 transition line-clamp-2">
                            {{ $video->title }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $video->description }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                                </svg>
                                {{ $video->category->name }}
                            </span>
                            <span>{{ $video->views }} views</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $videos->links() }}
        </div>
    @else
        <div class="card p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No videos found</h3>
            <p class="text-gray-600">Try selecting a different category</p>
        </div>
    @endif
</div>
@endsection