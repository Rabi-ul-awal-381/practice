@extends('layouts.app')

@section('title', 'Manage Videos - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Manage Videos</h1>
            <p class="text-gray-600">View and manage all uploaded videos</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="btn-primary">
            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            Upload New Video
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Thumbnail</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Title</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Category</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Access</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Views</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Date</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                @if($video->thumbnail)
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                         alt="{{ $video->title }}" 
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('videos.show', $video) }}" 
                                   class="text-green-600 hover:text-green-700 font-medium">
                                    {{ Str::limit($video->title, 40) }}
                                </a>
                                <p class="text-gray-500 text-sm">{{ Str::limit($video->description, 60) }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">
                                    {{ $video->category ? $video->category->name : 'No Category' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($video->access_level === 'paid')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-semibold">Premium</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-semibold">Free</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $video->views }}</td>
                            <td class="py-3 px-4 text-gray-600 text-sm">{{ $video->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.videos.edit', $video) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.videos.destroy', $video) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this video?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-gray-500">
                                No videos found. <a href="{{ route('admin.videos.create') }}" class="text-green-600 hover:text-green-700">Upload your first video</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $videos->links() }}
    </div>
</div>
@endsection