<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Models\VideoView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('videos')->get();
        $selectedCategory = $request->get('category');
        $search = $request->get('search');

        $query = Video::with('category')
            ->when($selectedCategory, fn($q) => $q->where('category_id', $selectedCategory))
            ->when($search, fn($q) => 
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
            );

        // Only show free videos to free users
        if (!auth()->user()->isPaidMember()) {
            $query->where('access_level', 'free');
        }

        $videos = $query->latest()->paginate(12);

        return view('videos.index', compact('videos', 'categories', 'selectedCategory', 'search'));
    }

    public function show(Video $video)
    {
        if ($video->access_level === 'premium' && !auth()->user()->isPaidMember()) {
            return redirect()->route('videos.index')
                ->with('error', 'This video requires a premium membership.');
        }

        VideoView::create([
            'user_id' => auth()->id(),
            'video_id' => $video->id,
            'viewed_at' => now(),
        ]);

        $video->increment('views');

        $relatedVideos = Video::where('category_id', $video->category_id)
            ->where('id', '!=', $video->id)
            ->when(!auth()->user()->isPaidMember(), fn($q) => $q->where('access_level', 'free'))
            ->limit(4)
            ->get();

        return view('videos.show', compact('video', 'relatedVideos'));
    }
}
