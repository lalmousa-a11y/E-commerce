@extends('admin.dashboard')

@section('title', 'Edit Seller - ' . $seller->user->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.sellers.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
            ← Back to Sellers
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Edit Seller: {{ $seller->user->name }}</h1>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <x-alert type="danger">
            <strong>Validation errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <!-- Edit Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Seller Information</h2>
                
                <form action="{{ route('admin.sellers.update', $seller->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- User Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $seller->user->name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            required
                        >
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- User Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $seller->user->email) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                            required
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Seller Status -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                            required
                        >
                            <option value="pending" {{ old('status', $seller->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $seller->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $seller->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Name -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shop Name</label>
                        <input 
                            type="text" 
                            name="shop_name" 
                            value="{{ old('shop_name', $seller->shop_name) }}"
                            placeholder="Enter shop name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('shop_name') border-red-500 @enderror"
                        >
                        @error('shop_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shop Description -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shop Description</label>
                        <textarea 
                            name="description" 
                            rows="4"
                            placeholder="Enter shop description"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                        >{{ old('description', $seller->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input 
                            type="tel" 
                            name="phone" 
                            value="{{ old('phone', $seller->phone) }}"
                            placeholder="Enter phone number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                        >
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input 
                            type="text" 
                            name="address" 
                            value="{{ old('address', $seller->address) }}"
                            placeholder="Enter address"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('address') border-red-500 @enderror"
                        >
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4">
                        <button 
                            type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200"
                        >
                            Save Changes
                        </button>
                        <a 
                            href="{{ route('admin.sellers.index') }}" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition duration-200"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="lg:col-span-1">
            <!-- Seller Stats Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Seller Statistics</h3>
                
                <div class="space-y-3">
                    <!-- Total Products -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-3">
                        <p class="text-xs text-gray-600">Total Products</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $seller->products->count() }}</p>
                    </div>

                    <!-- Total Orders -->
                    <div class="bg-green-50 border-l-4 border-green-500 p-3">
                        <p class="text-xs text-gray-600">Seller Orders</p>
                        <p class="text-2xl font-bold text-green-600">{{ $seller->products->sum(fn($p) => $p->orderItems->count()) }}</p>
                    </div>

                    <!-- Registration Date -->
                    <div class="bg-purple-50 border-l-4 border-purple-500 p-3">
                        <p class="text-xs text-gray-600">Joined Date</p>
                        <p class="text-sm font-bold text-purple-600">{{ $seller->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- Status Badge -->
                    <div class="p-3 rounded-lg
                        @if($seller->status === 'approved')
                            bg-green-100
                        @elseif($seller->status === 'rejected')
                            bg-red-100
                        @else
                            bg-yellow-100
                        @endif
                    ">
                        <p class="text-xs text-gray-600">Current Status</p>
                        <p class="text-lg font-bold
                            @if($seller->status === 'approved')
                                text-green-600
                            @elseif($seller->status === 'rejected')
                                text-red-600
                            @else
                                text-yellow-600
                            @endif
                        ">
                            {{ ucfirst($seller->status) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    <!-- View All Products -->
                    <a 
                        href="{{ route('admin.products.index', ['seller' => $seller->id]) }}" 
                        class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center font-semibold py-2 px-4 rounded-lg transition"
                    >
                        View Products
                    </a>

                    <!-- View Full Profile -->
                    <a 
                        href="{{ route('admin.sellers.show', $seller->id) }}" 
                        class="block w-full bg-gray-500 hover:bg-gray-600 text-white text-center font-semibold py-2 px-4 rounded-lg transition"
                    >
                        Full Profile
                    </a>

                    <!-- Delete Seller -->
                    <form 
                        action="{{ route('admin.sellers.destroy', $seller->id) }}" 
                        method="POST"
                        onsubmit="return confirm('Are you sure? All products will be deleted!');"
                    >
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition"
                        >
                            Delete Seller
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
