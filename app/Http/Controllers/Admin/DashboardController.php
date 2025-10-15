<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_videos' => Video::count(),
            'total_users' => User::count(),
            'paid_members' => User::where('membership_type', 'paid')->count(),
            'free_members' => User::where('membership_type', 'free')->count(),
        ];

        $recent_videos = Video::with('category')->latest()->take(5)->get();
        $recent_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_videos', 'recent_users'));
    }
}
