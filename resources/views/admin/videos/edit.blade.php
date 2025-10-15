@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Video</h1>
    
    <form action="{{ route('admin.videos.update', $video) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block mb-2">Title *</label>
            <input type="text" name="title" value="{{ old('title', $video->title) }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Description *</label>
            <textarea name="description" rows="4" required class="w-full border px-3 py-2 rounded">{{ old('description', $video->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2">Video URL *</label>
            <input type="url" name="video_url" value="{{ old('video_url', $video->video_url) }}" required class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Thumbnail</label>
            <input type="file" name="thumbnail" accept="image/*" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Category *</label>
            <select name="category_id" required class="w-full border px-3 py-2 rounded">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $video->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2">Access Level *</label>
            <select name="access_level" required class="w-full border px-3 py-2 rounded">
                <option value="free" {{ $video->access_level == 'free' ? 'selected' : '' }}>Free</option>
                <option value="paid" {{ $video->access_level == 'paid' ? 'selected' : '' }}>Premium</option>
            </select>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Update Video</button>
            <a href="{{ route('admin.videos.index') }}" class="bg-gray-300 px-6 py-2 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection