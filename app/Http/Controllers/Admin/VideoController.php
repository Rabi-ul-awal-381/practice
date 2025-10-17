<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Category;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $videos = Video::with('category')->latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'access_level' => 'required|in:free,paid',
        ]);

        Video::create($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video uploaded successfully!');
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        $categories = Category::all();
        return view('admin.videos.edit', compact('video', 'categories'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'access_level' => 'required|in:free,paid',
        ]);

        $video->update($validated);

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully!');
    }
}
