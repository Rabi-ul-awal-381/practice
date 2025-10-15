@extends('layouts.app')

@section('title', 'Admin Dashboard - Learn Islam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">Manage your Islamic learning platform</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-gray-600 text-sm font-medium">Total Videos</h3>
                <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                </svg>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ $stats['total_videos'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-gray-600 text-sm font-medium">Total Users</h3>
                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-gray-600 text-sm font-medium">Paid Members</h3>
                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ $stats['paid_members'] }}</p>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-gray-600 text-sm font-medium">Categories</h3>
                <svg class="w-8 h-8 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ \App\Models\Category::count() }}</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.videos.create') }}" class="btn-primary">
                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                Upload New Video
            </a>
            <a href="{{ route('admin.videos.index') }}" class="btn-secondary">
                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                </svg>
                Manage Videos
            </a>
        </div>
    </div>

    <!-- Recent Videos -->
    <div class="card p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Videos</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Title</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Category</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Access</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Views</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_videos as $video)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <a href="{{ route('videos.show', $video) }}" class="text-green-600 hover:text-green-700 font-medium">
                                    {{ Str::limit($video->title, 50) }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-sm">
                                    {{ $video->category ? $video->category->name : 'No Category' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($video->isPaid())
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-semibold">Premium</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-semibold">Free</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $video->views }}</td>
                            <td class="py-3 px-4 text-gray-600 text-sm">{{ $video->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection