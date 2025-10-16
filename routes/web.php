<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// User dashboard and videos
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $videos = \App\Models\Video::with('category')
            ->when(!auth()->user()->isPaidMember(), fn($q) => $q->where('access_level', 'free'))
            ->latest()
            ->take(6)
            ->get();
        return view('dashboard', compact('videos'));
    })->name('dashboard');

    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [VideoController::class, 'create'])->name('admin.videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('videos', App\Http\Controllers\Admin\VideoController::class);
});


Route::get('/api/fetch-youtube-info', function(Request $request) {
    $videoId = $request->get('video_id');
    
    if (!$videoId) {
        return response()->json(['error' => 'No video ID'], 400);
    }

    try {
        $response = Http::get("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v={$videoId}&format=json");
        
        if ($response->successful()) {
            return response()->json($response->json());
        }
        
        return response()->json(['error' => 'Failed to fetch'], 500);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});