<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Category;
use App\Models\VideoView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;



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