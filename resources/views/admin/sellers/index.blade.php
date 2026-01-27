@extends('admin.dashboard')

@section('title', 'Sellers Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Sellers Management</h1>
        <div class="text-sm text-gray-600">
            Total Sellers: <span class="font-bold text-lg">{{ $sellers->total() }}</span>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <!-- Error Alert -->
    @if($errors->any())
        <x-alert type="danger" message="{{ $errors->first() }}" />
    @endif

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.sellers.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name/Email</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search sellers..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>

            <!-- Filter Button -->
            <div class="flex items-end gap-2">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                >
                    Filter
                </button>
                <a 
                    href="{{ route('admin.sellers.index') }}" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg text-center transition duration-200"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Sellers Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Products</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Joined</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $seller->user->id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $seller->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $seller->user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    @if($seller->status === 'pending')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($seller->status === 'approved')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ ucfirst($seller->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $seller->products->count() }} products
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $seller->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <!-- View Button -->
                                    <a 
                                        href="{{ route('admin.sellers.show', $seller->id) }}" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold transition"
                                    >
                                        View
                                    </a>

                                    <!-- Edit Button -->
                                    <a 
                                        href="{{ route('admin.sellers.edit', $seller->id) }}" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs font-semibold transition"
                                    >
                                        Edit
                                    </a>

                                    <!-- Approve Button (if pending) -->
                                    @if($seller->status === 'pending')
                                        <form 
                                            action="{{ route('admin.sellers.approve', $seller->id) }}" 
                                            method="POST" 
                                            style="display: inline;"
                                            onsubmit="return confirm('Approve this seller?')"
                                        >
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Reject Button (if pending) -->
                                    @if($seller->status === 'pending')
                                        <form 
                                            action="{{ route('admin.sellers.reject', $seller->id) }}" 
                                            method="POST" 
                                            style="display: inline;"
                                            onsubmit="return confirm('Reject this seller?')"
                                        >
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                                Reject
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Button -->
                                    <form 
                                        action="{{ route('admin.sellers.destroy', $seller->id) }}" 
                                        method="POST" 
                                        style="display: inline;"
                                        onsubmit="return confirm('Delete this seller? All their products will be deleted too.')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <p class="text-lg">No sellers found</p>
                                <p class="text-sm">Try adjusting your filters</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $sellers->links() }}
    </div>
</div>
@endsection
