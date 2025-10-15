<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
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
        $stats = [
            'total_videos' => Video::count(),
            'total_users' => User::where('role', 'user')->count(),
            'paid_members' => User::where('membership_type', 'paid')->count(),
            'total_categories' => Category::count(),
        ];

        $recentVideos = Video::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentVideos'));
    }
}