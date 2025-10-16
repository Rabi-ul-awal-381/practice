<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $videos = Video::with('category')->latest()->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_file' => 'nullable|mimes:mp4,mov,avi,wmv|max:20000',
            'video_link' => 'nullable|url',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id', // ✅ validate category
        ]);
    
        // Ensure at least one video source
        if (!$request->video_file && !$request->video_link) {
            return back()->withErrors(['video_file' => 'Please upload a video or provide a video link.']);
        }
    
        // Prepare video data
        $videoData = [
            'user_id' => auth()->id(),
            'title' => $request->title ?? 'Untitled Video',
            'description' => $request->description ?? 'No description provided.',
            'video_path' => $request->video_file ? $request->video_file->store('videos', 'public') : null,
            'video_link' => $request->video_link ?? null,
            'access_level' => 'free',
            'category_id' => $request->category_id, // ✅ include category
        ];
    
        // Create video
        \App\Models\Video::create($videoData);
    
        return redirect()->route('videos.index')->with('success', 'Video uploaded successfully!');
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
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'video_url' => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'access_level' => 'required|in:free,paid',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video updated successfully!');
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video deleted successfully!');
    }
}