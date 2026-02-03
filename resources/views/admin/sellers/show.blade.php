@extends('layouts.admin')

@section('title', 'Seller Profile - ' . optional($seller->user)->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="mb-6">
        <a href="{{ route('admin.sellers.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
            ← Back to Sellers
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Seller Profile</h1>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <!-- Error Alert -->
    @if($errors->any())
        <x-alert type="danger" message="{{ $errors->first() }}" />
    @endif

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Seller Information -->
        <div class="lg:col-span-2">
            <!-- Seller Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-white">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-white text-blue-600 font-bold text-xl">
                                {{ substr(optional($seller->user)->name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ optional($seller->user)->name }}</h2>
                            <p class="text-blue-100">{{ $seller->shop_name ?? 'No Shop Name' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="px-6 py-6">
                    <!-- Status Badge -->
                    <div class="mb-6">
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-bold
                            @if($seller->status === 'approved')
                                bg-green-100 text-green-800
                            @elseif($seller->status === 'rejected')
                                bg-red-100 text-red-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif
                        ">
                            Status: {{ ucfirst($seller->status) }}
                        </span>
                    </div>

                    <!-- Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-200 pb-6 mb-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <p class="text-gray-600">{{  optional($seller->user)->email }}</p>
                        </div>

                    

                        <!-- Member Since -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Member Since</label>
                            <p class="text-gray-600">{{ $seller->created_at->format('F d, Y') }}</p>
                        </div>

                        <!-- Last Updated -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Last Updated</label>
                            <p class="text-gray-600">{{ $seller->updated_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($seller->description)
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">About Shop</label>
                            <p class="text-gray-600">{{ $seller->description }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <a 
                            href="{{ route('admin.sellers.edit', $seller->id) }}" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition"
                        >
                            Edit Seller
                        </a>

                        @if($seller->status === 'pending')
                            <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                    Approve
                                </button>
                            </form>

                            <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                                    Reject
                                </button>
                            </form>
                        @endif

                        <form 
                            action="{{ route('admin.sellers.destroy', $seller->id) }}" 
                            method="POST" 
                            style="display: inline;"
                            onsubmit="return confirm('Are you sure? All products will be deleted!');"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-lg transition">
                                Delete Seller
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">
                    Products ({{ $seller->products->count() }})
                </h3>

                @if($seller->products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Product Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Category</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Price</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Stock</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seller->products as $product)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ Str::limit($product->name, 30) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $product->category->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            ${{ number_format($product->price, 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ $product->stock ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($product->status === 'active')
                                                    bg-green-100 text-green-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <a 
                                                href="{{ route('admin.products.show', $product->id) }}" 
                                                class="text-blue-600 hover:text-blue-800 font-semibold"
                                            >
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500 py-6">No products found for this seller.</p>
                @endif
            </div>
        </div>

        <!-- Right Column - Statistics & Quick Info -->
        <div class="lg:col-span-1">
            <!-- Statistics Cards -->
            <div class="space-y-4 mb-6">
                <!-- Total Products -->
                <x-stats-card 
                    title="Total Products" 
                    value="{{ $seller->products->count() }}" 
                    icon="📦"
                    color="blue"
                />

                <!-- Total Orders -->
                <x-stats-card 
                    title="Total Orders" 
                    value="{{ $seller->products->sum(fn($p) => $p->orderItems->count()) }}" 
                    icon="📋"
                    color="green"
                />

                <!-- Total Revenue -->
                <x-stats-card 
                    title="Total Revenue" 
                    value="${{ number_format($seller->products->sum(fn($p) => $p->orderItems->sum('quantity') * $p->price), 2) }}" 
                    icon="💰"
                    color="purple"
                />

                <!-- Active Products -->
                <x-stats-card 
                    title="Active Products" 
                    value="{{ $seller->products->where('status', 'active')->count() }}" 
                    icon="✅"
                    color="yellow"
                />
            </div>

            <!-- Quick Info Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Account Status</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">User ID:</span>
                        <span class="font-semibold text-gray-800">{{ $seller->user_id }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Seller ID:</span>
                        <span class="font-semibold text-gray-800">{{ $seller->id }}</span>
                    </div>

                    <hr class="my-2">

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            @if($seller->status === 'approved')
                                bg-green-100 text-green-800
                            @elseif($seller->status === 'rejected')
                                bg-red-100 text-red-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif
                        ">
                            {{ ucfirst($seller->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Contact Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Contact Information</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-600 mb-1">Email</p>
                        <a href="mailto:{{ optional($seller->user)->email }}" class="text-blue-600 hover:text-blue-800 font-semibold break-all">
                            {{ optional($seller->user)->email }}
                        </a>
                    </div>

                    @if($seller->phone)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Phone</p>
                            <a href="tel:{{ $seller->phone }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                {{ $seller->phone }}
                            </a>
                        </div>
                    @endif

                    @if($seller->address)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Address</p>
                            <p class="text-gray-700 text-sm">{{ $seller->address }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
