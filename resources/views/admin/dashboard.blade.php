@extends('layouts.admin')

@section('title', 'control panel dashboard')
@section('page-title', '📊 main control panel')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.stats-card 
            title="total sellers" 
            :value="$stats['total_sellers']"
            icon="👥"
            color="yellow"
            subtitle="{{ $stats['pending_sellers'] }} pending"
        />

        <x-admin.stats-card 
            title="total products" 
            :value="$stats['total_products']"
            icon="📦"
            color="green"
            subtitle="{{ $stats['approved_products'] }} approved"
        />

        <x-admin.stats-card 
            title="pending products" 
            :value="$stats['pending_products']"
            icon="⏳"
            color="yellow"
            subtitle="{{ $stats['rejected_products'] }} rejected"
        />

        <x-admin.stats-card 
            title="total orders" 
            :value="$stats['total_orders']"
            icon="🛒"
            color="blue"
            subtitle="{{ $stats['pending_orders'] }} pending"
        />
                </div>
                <div class="text-4xl">🛒</div>
            </div>
        </div>

        <x-admin.stats-card 
            title="total revenue" 
            :value="number_format($stats['total_revenue'], 2) . ' Riyals'"
            icon="💰"
            color="green"
        />

        <x-admin.stats-card 
            title="completed orders" 
            :value="$stats['completed_orders']"
            icon="✅"
            color="green"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <h3 class="text-lg font-bold">📋 Last Orders</h3>
            </div>
            
            @if($recent_orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Order ID</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Customer</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Amount</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $order)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:underline">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $order->user->name }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold">{{ $order->total_amount }} ر.س</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $order->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 bg-gray-50 border-t">
                    <a href="{{ route('orders.index') }}" class="text-blue-600 text-sm hover:underline">
                        👉 view all orders→
                    </a>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    <p>no orders yet</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                <h3 class="text-lg font-bold">📦 Last Products</h3>
            </div>
            
            @if($recent_products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Product Name</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Seller</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_products as $product)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm">{{ substr($product->name, 0, 30) }}...</td>
                                    <td class="px-6 py-4 text-sm">{{ $product->seller->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($product->status === 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">⏳ pending</span>
                                        @elseif($product->status === 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">✅ approved</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">❌ rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('products.show', $product->id) }}" class="text-blue-600 text-sm hover:underline">
                                            عرض
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-3 bg-gray-50 border-t">
                    <a href="{{ route('products.index') }}" class="text-blue-600 text-sm hover:underline">
                        👉 view all products→
                    </a>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">
                    <p>no products yet</p>
                </div>
            @endif
        </div>
    </div>
@endsection