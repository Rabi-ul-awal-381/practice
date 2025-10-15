@extends('layouts.app')

@section('title', $video->title . ' - Learn Islam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Video Section -->
        <div class="lg:col-span-2">
            <!-- Video Player -->
            <div class="bg-black rounded-xl overflow-hidden shadow-2xl mb-6">
                <div class="aspect-video">
                    <iframe 
                        src="{{ $video->video_url }}" 
                        class="w-full h-full"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Video Info -->
            <div class="card p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $video->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ $video->views }} views
                            </span>
                            <span>•</span>
                            <span>{{ $video->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @if($video->isPaid())
                        <span class="bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold">
                            PREMIUM
                        </span>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex items-center mb-4">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $video->category->name }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $video->description }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar - Related Videos -->
        <div class="lg:col-span-1">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Related Videos</h2>
            
            @if($relatedVideos->count() > 0)
                <div class="space-y-4">
                    @foreach($relatedVideos as $relatedVideo)
                        <a href="{{ route('videos.show', $relatedVideo) }}" class="card flex overflow-hidden hover:shadow-lg transition group">
                            <div class="w-40 flex-shrink-0 relative">
                                @if($relatedVideo->thumbnail)
                                    <img src="{{ asset('storage/' . $relatedVideo->thumbnail) }}" alt="{{ $relatedVideo->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($relatedVideo->isPaid())
                                    <span class="absolute top-1 right-1 bg-yellow-400 text-yellow-900 px-1.5 py-0.5 rounded text-xs font-bold">
                                        PRO
                                    </span>
                                @endif
                            </div>
                            <div class="p-3 flex-1">
                                <h3 class="font-semibold text-gray-800 text-sm mb-1 line-clamp-2 group-hover:text-green-600 transition">
                                    {{ $relatedVideo->title }}
                                </h3>
                                <p class="text-xs text-gray-500">{{ $relatedVideo->views }} views</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="card p-6 text-center">
                    <p class="text-gray-600 text-sm">No related videos available</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection