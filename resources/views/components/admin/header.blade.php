<!-- Header -->
<header class="bg-white shadow-md border-b border-gray-200">
    <div class="px-6 sm:px-8 py-4 sm:py-5 flex justify-between items-center">
        <!-- Left: Page Title -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ $subtitle ?? '' }}</p>
        </div>

        <!-- Right: User Info & Actions -->
        <div class="flex items-center space-x-4 sm:space-x-6">
            <!-- User Avatar & Dropdown -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>