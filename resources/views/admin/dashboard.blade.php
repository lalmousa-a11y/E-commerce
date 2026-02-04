@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', '📊 Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600 text-sm md:text-base">Monitor your store performance and manage your business</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-8">
        <!-- Total Users -->
        <x-admin.stats-card 
            title="Total Users" 
            :value="$stats['total_users']??0"
            icon="🧑"
            color="purple"
            subtitle="All registered users"
        />

        <!-- Total Sellers -->
        <x-admin.stats-card 
            title="Total Sellers" 
            :value="$stats['total_sellers'] ?? 0"
            icon="👥"
            color="yellow"
            subtitle="{{ $stats['pending_sellers'] ?? 0 }} pending"
        />

        <!-- Total Products -->
        <x-admin.stats-card 
            title="Total Products" 
            :value="$stats['total_products'] ?? 0"
            icon="📦"
            color="green"
            subtitle="{{ $stats['approved_products'] ?? 0 }} approved"
        />

        <!-- Pending Products -->
        <x-admin.stats-card 
            title="Pending Products" 
            :value="$stats['pending_products'] ?? 0"
            icon="⏳"
            color="yellow"
            subtitle="{{ $stats['rejected_products'] ?? 0 }} rejected"
        />

        <!-- Total Orders -->
        <x-admin.stats-card 
            title="Total Orders" 
            :value="$stats['total_orders'] ?? 0"
            icon="🛒"
            color="blue"
            subtitle="{{ $stats['pending_orders'] ?? 0 }} pending"
        />
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 mb-8">
        <x-admin.stats-card 
            title="Total Revenue" 
            :value="number_format($stats['total_revenue'] ?? 0, 2) . ' SAR'"
            icon="💰"
            color="green"
        />

        <x-admin.stats-card 
            title="Completed Orders" 
            :value="$stats['completed_orders'] ?? 0"
            icon="✅"
            color="green"
        />
    </div>

    <!-- Recent Data Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 sm:p-8 border border-gray-200">
            <div class="px-0 sm:px-2 py-0 sm:py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg mb-6 p-6">
                <h3 class="text-lg sm:text-xl font-bold">📋 Recent Orders</h3>
            </div>

            @if($recent_orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Order ID</th>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Customer</th>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Amount</th>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-4 sm:px-6 py-4">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $order->user->name }}</td>
                                    <td class="px-4 sm:px-6 py-4 text-sm font-semibold text-gray-900">{{ $order->total_amount }} SAR</td>
                                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-600">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 sm:px-8 py-4 bg-gray-50 border-t rounded-b-lg">
                    <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        View all orders →
                    </a>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-base">No orders yet</p>
                </div>
            @endif
        </div>

        <!-- Recent Products -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 sm:p-8 border border-gray-200">
            <div class="px-0 sm:px-2 py-0 sm:py-2 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg mb-6 p-6">
                <h3 class="text-lg sm:text-xl font-bold">📦 Recent Products</h3>
            </div>

            @if($recent_products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Product Name</th>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Seller</th>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-4 sm:px-6 py-4 text-left text-sm font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_products as $product)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ substr($product->name, 0, 30) }}...</td>
                                    <td class="px-4 sm:px-6 py-4 text-sm text-gray-700">{{ $product->seller->name }}</td>
                                    <td class="px-4 sm:px-6 py-4">
                                        @if($product->status === 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-medium">⏳ Pending</span>
                                        @elseif($product->status === 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">✅ Approved</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-medium">❌ Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-4">
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 sm:px-8 py-4 bg-gray-50 border-t rounded-b-lg">
                    <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        View all products →
                    </a>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-base">No products yet</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
