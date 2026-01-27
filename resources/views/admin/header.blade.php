<header class="bg-white shadow">
    <div class="px-6 py-4 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">@yield('page-title', 'control panel')</h2>
        
        <div class="text-right">
            <p class="text-gray-600">hello{{ auth()->user()->name }}</p>
        </div>
    </div>
</header>