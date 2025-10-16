@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Add a New Video</h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data"
              class="max-w-3xl mx-auto bg-white p-8 rounded shadow space-y-6">
            @csrf

            <!-- External Video Link - MOVED TO TOP -->
            <div>
                <label for="video_url" class="block text-gray-700 font-semibold mb-2">
                    YouTube/Vimeo Link
                    <span class="text-sm text-gray-500 font-normal">(Paste link first, title will auto-fill!)</span>
                </label>
                <input type="url" name="video_url" id="video_url" 
                       placeholder="https://www.youtube.com/watch?v=..."
                       value="{{ old('video_url') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-500 text-sm mt-1">
                    <span id="fetch-status" class="hidden text-green-600">✓ Fetching video info...</span>
                </p>
            </div>

            <!-- Video Title -->
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-2">
                    Video Title 
                    <span class="text-sm text-gray-500 font-normal">(Auto-filled from link)</span>
                </label>
                <input type="text" name="title" id="title" placeholder="Enter video title"
                       value="{{ old('title') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Video Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">
                    Description 
                    <span class="text-sm text-gray-500 font-normal">(Auto-filled from link)</span>
                </label>
                <textarea name="description" id="description" placeholder="Enter description"
                          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          rows="4">{{ old('description') }}</textarea>
            </div>

            <!-- OR Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-gray-500 font-semibold">OR</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <!-- Local Video Upload -->
            <div>
                <label for="video_file" class="block text-gray-700 font-semibold mb-2">Upload Video File</label>
                <input type="file" name="video_file" id="video_file" accept="video/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-500 text-sm mt-1">Max size: 20MB. Supported: MP4, MOV, AVI, WMV</p>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded font-semibold hover:bg-indigo-700 transition duration-300">
                Save Video
            </button>
        </form>
    </div>
</section>

<script>
let fetchTimeout;

document.getElementById('video_url').addEventListener('input', function() {
    clearTimeout(fetchTimeout);
    const link = this.value.trim();
    
    if (!link) return;

    const statusEl = document.getElementById('fetch-status');
    statusEl.classList.remove('hidden');

    // Debounce the fetch request
    fetchTimeout = setTimeout(async () => {
        // Check if it's YouTube
        const youtubeMatch = link.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
        
        if (!youtubeMatch) {
            statusEl.classList.add('hidden');
            return;
        }

        const videoId = youtubeMatch[1];

        try {
            // Use a CORS proxy or direct API call
            const response = await fetch(`/api/fetch-youtube-info?video_id=${videoId}`);
            
            if (!response.ok) {
                // Fallback to oEmbed
                const oEmbedResponse = await fetch(`https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=${videoId}&format=json`);
                const data = await oEmbedResponse.json();
                
                updateFields(data);
                statusEl.textContent = '✓ Video info loaded!';
                setTimeout(() => statusEl.classList.add('hidden'), 3000);
                return;
            }

            const data = await response.json();
            updateFields(data);
            statusEl.textContent = '✓ Video info loaded!';
            setTimeout(() => statusEl.classList.add('hidden'), 3000);

        } catch (err) {
            console.error('Failed to fetch:', err);
            statusEl.textContent = '⚠ Could not fetch video info';
            statusEl.classList.remove('text-green-600');
            statusEl.classList.add('text-orange-600');
            setTimeout(() => statusEl.classList.add('hidden'), 3000);
        }
    }, 1000);
});

function updateFields(data) {
    const titleInput = document.getElementById('title');
    const descInput = document.getElementById('description');

    if (!titleInput.value && data.title) {
        titleInput.value = data.title;
        titleInput.classList.add('bg-green-50', 'border-green-300');
        setTimeout(() => {
            titleInput.classList.remove('bg-green-50', 'border-green-300');
        }, 2000);
    }

    if (!descInput.value && data.author_name) {
        descInput.value = `Video by ${data.author_name}`;
        descInput.classList.add('bg-green-50', 'border-green-300');
        setTimeout(() => {
            descInput.classList.remove('bg-green-50', 'border-green-300');
        }, 2000);
    }
}
</script>
@endsection