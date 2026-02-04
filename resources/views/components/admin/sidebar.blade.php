<!-- Sidebar Navigation -->
<aside class="w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 text-white shadow-2xl fixed h-screen overflow-y-auto">
    <!-- Logo/Brand -->
    <div class="p-6 border-b border-gray-700 sticky top-0 bg-gray-900">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-xl">⚙️</span>
            </div>
            <h1 class="text-2xl font-bold">Admin Panel</h1>
        </div>
        <p class="text-gray-400 text-sm">Store Management</p>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-8 pb-32">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white border-r-4 border-blue-400' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2 3l2-3m2 3l2-3m2 3l2-3m2 3l2-3M3 20l2-3m2 3l2-3m2 3l2-3m2 3l2-3m2 3l2-3"></path>
            </svg>
            Dashboard
        </a>

        <!-- Sellers Management -->
        <div class="mt-4">
            <button onclick="toggleMenu('sellers')"
                    class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                </svg>
                <span>Sellers</span>
                <svg class="w-4 h-4 ml-auto transition-transform" id="sellers-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
            <div id="sellers-menu" class="hidden bg-gray-800">
                <a href="{{ route('admin.sellers.index') }}"
                   class="block px-12 py-2 text-gray-400 hover:text-white hover:bg-gray-700 text-sm transition {{ request()->routeIs('admin.sellers.*') ? 'text-blue-400 bg-gray-700' : '' }}">
                    All Sellers
                </a>
            </div>
        </div>

        <!-- Products Management -->
        <div class="mt-4">
            <button onclick="toggleMenu('products')"
                    class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10M8 7v10"></path>
                </svg>
                <span>Products</span>
                <svg class="w-4 h-4 ml-auto transition-transform" id="products-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
            <div id="products-menu" class="hidden bg-gray-800">
                <a href="{{ route('admin.products.index') }}"
                   class="block px-12 py-2 text-gray-400 hover:text-white hover:bg-gray-700 text-sm transition {{ request()->routeIs('admin.products.*') ? 'text-blue-400 bg-gray-700' : '' }}">
                    All Products
                </a>
            </div>
        </div>

        <!-- Orders Management -->
        <div class="mt-4">
            <button onclick="toggleMenu('orders')"
                    class="w-full flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition font-medium">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>Orders</span>
                <svg class="w-4 h-4 ml-auto transition-transform" id="orders-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </button>
            <div id="orders-menu" class="hidden bg-gray-800">
                <a href="{{ route('admin.orders.index') }}"
                   class="block px-12 py-2 text-gray-400 hover:text-white hover:bg-gray-700 text-sm transition {{ request()->routeIs('admin.orders.*') ? 'text-blue-400 bg-gray-700' : '' }}">
                    All Orders
                </a>
            </div>
        </div>
    </nav>

    <!-- Bottom Logout Section -->
    <div class="fixed bottom-0 w-64 border-t border-gray-700 p-6 bg-gray-900">
        <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg transition font-semibold shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
function toggleMenu(menuId) {
    const menu = document.getElementById(menuId + '-menu');
    const icon = document.getElementById(menuId + '-icon');
    
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        menu.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>