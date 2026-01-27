<!-- Header -->
<header class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto py-4 px-6 sm:px-8 flex justify-between items-center">
        <!-- Left: Page Title -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $subtitle ?? '' }}</p>
        </div>

        <!-- Right: User Info & Actions -->
        <div class="flex items-center space-x-4">
            <!-- User Avatar & Dropdown -->
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>