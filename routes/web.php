<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 👤 Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 🚪 Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// 🎥 Videos — accessible to everyone (guests + logged-in users)
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');


// 👥 User routes (authenticated only)
Route::middleware('auth')->group(function () {
    // User dashboard
    Route::get('/dashboard', function () {
        $user = \App\Models\User::find(auth()->id());
        auth()->setUser($user);

        $videos = \App\Models\Video::with('category')
            ->when(!$user->isPaidMember(), fn($q) => $q->where('access_level', 'free'))
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('videos'));
    })->name('dashboard');

    // Video upload (only for logged-in users)
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
});



// 💳 Payment routes (open for both logged-in and pending users)
Route::get('/upgrade', [PaymentController::class, 'showPage'])->name('payments.checkout');
Route::post('/create-checkout-session', [PaymentController::class, 'createSession'])->name('payments.session');
Route::get('/payment-success', [PaymentController::class, 'success'])->name('payments.success');
Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');



// 🧠 Admin routes
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('videos', AdminVideoController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    });


// ✅ Optional API helper
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/api/fetch-youtube-info', function (Request $request) {
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
