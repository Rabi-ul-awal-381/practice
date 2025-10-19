<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Learn Islam')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'green-700': '#15803d',
                        'emerald-700': '#047857',
                        'green-50': '#f0fdf4',
                    }
                }
            }
        }
    </script>
    <style>
        .card {
            @apply bg-white rounded-lg shadow-md;
        }
        .btn-primary {
            @apply bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 inline-flex items-center;
        }
        .btn-secondary {
            @apply bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 inline-flex items-center;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-green-700 to-emerald-700 shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-white flex items-center space-x-2">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                        <span>Learn Islam</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
    <!-- ✅ Videos link always visible -->
    <a href="{{ route('videos.index') }}" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition">
        Videos
    </a>

    @auth
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition">
                Admin Panel
            </a>
        @endif

        <a href="{{ route('dashboard') }}" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition">
            Dashboard
        </a>

        <div class="flex items-center space-x-3">
            <span class="text-white text-sm">{{ auth()->user()->name }}</span>
            @if(auth()->user()->isPaidMember())
                <span class="bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-bold">PREMIUM</span>
            @else
                <span class="bg-gray-300 text-gray-700 px-2 py-1 rounded-full text-xs font-bold">FREE</span>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Logout
                </button>
            </form>
        </div>
    @else
        <a href="{{ route('login') }}" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-sm font-medium transition">
            Login
        </a>
        <a href="{{ route('register') }}" class="bg-white text-green-700 hover:bg-green-50 px-4 py-2 rounded-lg text-sm font-medium transition">
            Register
        </a>
    @endauth
</div>

            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Learn Islam. All rights reserved.</p>
                <p class="text-gray-500 text-sm mt-2">Spreading Islamic knowledge to the world</p>
            </div>
        </div>
    </footer>
</body>
</html>