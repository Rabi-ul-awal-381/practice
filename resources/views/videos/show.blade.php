@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Video Player -->
        <div class="bg-black rounded-lg overflow-hidden mb-6" style="aspect-ratio: 16/9;">
            @if($video->video_url)
                @php
                    // Extract YouTube video ID
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $video->video_url, $matches);
                    $youtubeId = $matches[1] ?? null;
                    
                    // Extract Vimeo video ID
                    preg_match('/vimeo\.com\/(\d+)/', $video->video_url, $vimeoMatches);
                    $vimeoId = $vimeoMatches[1] ?? null;
                @endphp

                @if($youtubeId)
                    <!-- YouTube Embed -->
                    <iframe 
                        width="100%" 
                        height="100%" 
                        src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen
                        class="w-full h-full">
                    </iframe>
                @elseif($vimeoId)
                    <!-- Vimeo Embed -->
                    <iframe 
                        src="https://player.vimeo.com/video/{{ $vimeoId }}" 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        allow="autoplay; fullscreen; picture-in-picture" 
                        allowfullscreen
                        class="w-full h-full">
                    </iframe>
                @else
                    <!-- Generic Video Embed -->
                    <video controls class="w-full h-full">
                        <source src="{{ $video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            @elseif($video->video_path)
                <!-- Local Video -->
                <video controls class="w-full h-full">
                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <div class="flex items-center justify-center h-full bg-gray-800 text-white">
                    <p>Video not available</p>
                </div>
            @endif
        </div>

        <!-- Video Info -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $video->title }}</h1>
                    <div class="flex items-center space-x-4 text-gray-600 text-sm">
                        <span>{{ $video->views }} views</span>
                        <span>•</span>
                        <span>{{ $video->created_at->diffForHumans() }}</span>
                        @if($video->category)
                            <span>•</span>
                            <span class="bg-gray-100 px-2 py-1 rounded">{{ $video->category->name }}</span>
                        @endif
                    </div>
                </div>
                @if($video->access_level === 'paid')
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Premium</span>
                @else
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Free</span>
                @endif
            </div>

            <div class="border-t pt-4">
                <h3 class="font-semibold text-gray-800 mb-2">Description</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $video->description }}</p>
            </div>
        </div>

        <!-- Related Videos -->
        @if($relatedVideos->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Related Videos</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($relatedVideos as $related)
                        <a href="{{ route('videos.show', $related) }}" class="group">
                            <div class="bg-gray-100 rounded-lg overflow-hidden mb-2" style="aspect-ratio: 16/9;">
                                @if($related->thumbnail)
                                    <img src="{{ asset('storage/' . $related->thumbnail) }}" 
                                         alt="{{ $related->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <h3 class="font-semibold text-gray-800 group-hover:text-green-600 line-clamp-2">
                                {{ $related->title }}
                            </h3>
                            <p class="text-sm text-gray-600">{{ $related->views }} views</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection