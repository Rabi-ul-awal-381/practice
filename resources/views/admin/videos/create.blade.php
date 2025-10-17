@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-lg p-10 max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">🎥 Add a New Video</h1>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Video Link --}}
                <div>
                    <label for="video_url" class="block text-gray-700 font-semibold mb-2">
                        YouTube/Vimeo Link
                        <span class="text-sm text-gray-500 font-normal">(Paste link first — title auto-fills)</span>
                    </label>
                    <input type="url" name="video_url" id="video_url"
                           placeholder="https://www.youtube.com/watch?v=..."
                           value="{{ old('video_url') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-sm mt-2 text-gray-500">
                        <span id="fetch-status" class="hidden text-green-600">✓ Fetching video info...</span>
                    </p>
                </div>

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-gray-700 font-semibold mb-2">
                        Video Title
                        <span class="text-sm text-gray-500 font-normal">(Auto-filled from link)</span>
                    </label>
                    <input type="text" name="title" id="title"
                           placeholder="Enter video title"
                           value="{{ old('title') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-gray-700 font-semibold mb-2">
                        Description
                        <span class="text-sm text-gray-500 font-normal">(Optional)</span>
                    </label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Enter video description..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                {{-- OR Divider --}}
                <div class="flex items-center gap-3 my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="text-gray-500 font-semibold">OR</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                {{-- Upload File --}}
                <div>
                    <label for="video_file" class="block text-gray-700 font-semibold mb-2">Upload Video File</label>
                    <input type="file" name="video_file" id="video_file" accept="video/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-gray-500 text-sm mt-1">Max 20MB — MP4, MOV, AVI, WMV supported</p>
                </div>

                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-gray-700 font-semibold mb-2">Category</label>
                    <select name="category_id" id="category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Access Level --}}
                <div>
                    <label for="access_level" class="block text-gray-700 font-semibold mb-2">Access Level</label>
                    <select name="access_level" id="access_level"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="free">Free</option>
                        <option value="paid">Premium</option>
                    </select>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-semibold transition duration-300 shadow">
                    💾 Save Video
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Auto-fill script --}}
<script>
let fetchTimeout;

document.getElementById('video_url').addEventListener('input', function() {
    clearTimeout(fetchTimeout);
    const link = this.value.trim();
    if (!link) return;

    const statusEl = document.getElementById('fetch-status');
    statusEl.classList.remove('hidden');
    statusEl.textContent = 'Fetching video info...';

    fetchTimeout = setTimeout(async () => {
        const youtubeMatch = link.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
        if (!youtubeMatch) {
            statusEl.textContent = '⚠ Not a valid YouTube link';
            setTimeout(() => statusEl.classList.add('hidden'), 3000);
            return;
        }

        const videoId = youtubeMatch[1];
        try {
            const response = await fetch(`/api/fetch-youtube-info?video_id=${videoId}`);
            const data = await response.json();
            updateFields(data);
            statusEl.textContent = '✓ Video info loaded!';
            setTimeout(() => statusEl.classList.add('hidden'), 3000);
        } catch (err) {
            statusEl.textContent = '⚠ Could not fetch video info';
            setTimeout(() => statusEl.classList.add('hidden'), 3000);
        }
    }, 800);
});

function updateFields(data) {
    const titleInput = document.getElementById('title');
    const descInput = document.getElementById('description');

    if (!titleInput.value && data.title) {
        titleInput.value = data.title;
        flashHighlight(titleInput);
    }
    if (!descInput.value && data.author_name) {
        descInput.value = `Video by ${data.author_name}`;
        flashHighlight(descInput);
    }
}

function flashHighlight(element) {
    element.classList.add('bg-green-50', 'border-green-300');
    setTimeout(() => element.classList.remove('bg-green-50', 'border-green-300'), 2000);
}
</script>
@endsection
