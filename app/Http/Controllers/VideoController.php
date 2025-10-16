<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Models\VideoView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class VideoController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('videos')->get();
        $selectedCategory = $request->get('category');

        $query = Video::with('category')
            ->when($selectedCategory, function ($q) use ($selectedCategory) {
                return $q->where('category_id', $selectedCategory);
            });

        if (!auth()->user()->isPaidMember()) {
            $query->where('access_level', 'free');
        }

        $videos = $query->latest()->paginate(12);

        return view('videos.index', compact('videos', 'categories', 'selectedCategory'));
    }

    public function create()
{
    // Return a form view for uploading a video
    return view('videos.create');
}

public function store(Request $request)
{
    // Validate input
    $request->validate([
        'video_file' => 'nullable|mimes:mp4,mov,avi,wmv|max:20000',
        'video_url' => 'nullable|url',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);

    // Ensure at least one source
    if (!$request->hasFile('video_file') && !$request->filled('video_url')) {
        return back()->withErrors(['video_file' => 'Please upload a video or provide a video link.']);
    }

    $videoData = [
        'user_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
        'video_path' => null,
        'video_url' => $request->video_url ?? '',
        'access_level' => 'free',
        'category_id' => null,
        'views' => 0,
    ];

    // Handle local file upload
    if ($request->hasFile('video_file')) {
        $path = $request->file('video_file')->store('videos', 'public');
        $videoData['video_path'] = $path;
        $videoData['video_url'] = '';
    }

    // If title is empty and we have a YouTube URL, fetch the info
    if (empty($videoData['title']) && !empty($videoData['video_url'])) {
        $link = $videoData['video_url'];

        // Auto-fetch for YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $link, $matches)) {
            $videoId = $matches[1];
            
            try {
                $response = Http::timeout(5)->get("https://www.youtube.com/oembed", [
                    'url' => "https://www.youtube.com/watch?v={$videoId}",
                    'format' => 'json'
                ]);
                
                if ($response->successful()) {
                    $json = $response->json();
                    
                    if (empty($videoData['title']) && isset($json['title'])) {
                        $videoData['title'] = $json['title'];
                    }
                    
                    if (empty($videoData['description']) && isset($json['author_name'])) {
                        $videoData['description'] = 'Video by ' . $json['author_name'];
                    }
                    
                    \Log::info('YouTube info fetched successfully', ['title' => $json['title'] ?? 'N/A']);
                }
            } catch (\Exception $e) {
                \Log::error('YouTube fetch failed: ' . $e->getMessage());
            }
        }
    }

    // FINAL fallback for title and description
    if (empty($videoData['title'])) {
        $videoData['title'] = 'Untitled Video';
    }
    
    if (empty($videoData['description'])) {
        $videoData['description'] = 'No description provided.';
    }

    // Set default category if exists
    $defaultCategory = \App\Models\Category::first();
    if ($defaultCategory) {
        $videoData['category_id'] = $defaultCategory->id;
    }

    // CREATE VIDEO
    \App\Models\Video::create($videoData);

    return redirect()->route('videos.index')->with('success', 'Video uploaded successfully!');
}



    public function show(Video $video)
    {
        if ($video->isPaid() && !auth()->user()->isPaidMember()) {
            return redirect()->route('videos.index')
                ->with('error', 'This video requires a paid membership.');
        }

        VideoView::create([
            'user_id' => auth()->id(),
            'video_id' => $video->id,
            'viewed_at' => now(),

        ]);

        $video->increment('views');

        $relatedVideos = Video::where('category_id', $video->category_id)
            ->where('id', '!=', $video->id)
            ->when(!auth()->user()->isPaidMember(), function ($q) {
                return $q->where('access_level', 'free');
            })
            ->limit(4)
            ->get();

        return view('videos.show', compact('video', 'relatedVideos'));
    }
}