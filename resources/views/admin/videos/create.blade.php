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

        <form action="{{ route('videos.index') }}" method="POST" enctype="multipart/form-data"
              class="max-w-3xl mx-auto bg-white p-8 rounded shadow space-y-6">
            @csrf

            <!-- Video Title -->
            <div>
                <label for="title" class="block text-gray-700 font-semibold mb-2">Video Title (Optional)</label>
                <input type="text" name="title" id="title" placeholder="Enter video title"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Video Description -->
            <div>
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description (Optional)</label>
                <textarea name="description" id="description" placeholder="Enter description"
                          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                          rows="4"></textarea>
            </div>

            <!-- External Video Link -->
            <div>
                <label for="video_link" class="block text-gray-700 font-semibold mb-2">Video Link (YouTube, Vimeo, etc.)</label>
                <input type="url" name="video_link" id="video_link" placeholder="https://www.youtube.com/watch?v=..."
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-500 text-sm mt-1">Optional: If you paste a video link, title & description can auto-fill.</p>
            </div>

            <!-- Local Video Upload -->
            <div>
                <label for="video_file" class="block text-gray-700 font-semibold mb-2">Upload Video File</label>
                <input type="file" name="video_file" id="video_file" accept="video/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded font-semibold hover:bg-indigo-700 transition duration-300">
                Save Video
            </button>
        </form>
    </div>
</section>

<script>
document.getElementById('video_link').addEventListener('change', async function () {
    const link = this.value.trim();
    if (!link) return;

    // Only handle YouTube links for now
    const youtubeMatch = link.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    if (!youtubeMatch) return;

    const videoId = youtubeMatch[1];
    try {
        // Fetch title from YouTube oEmbed API
        const res = await fetch(`https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=${videoId}&format=json`);
        const data = await res.json();

        // Auto-fill title if empty
        const titleInput = document.getElementById('title');
        if (!titleInput.value) titleInput.value = data.title;

        // Auto-fill description if empty
        const descInput = document.getElementById('description');
        if (!descInput.value) descInput.value = data.author_name ? `Video by ${data.author_name}` : '';

    } catch (err) {
        console.error('Failed to fetch video info', err);
    }
});
</script>
@endsection
