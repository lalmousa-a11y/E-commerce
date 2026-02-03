@extends('layouts.admin')

@section('title', ' products management')
@section('page-title', '📦 products management')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🔍 search:</label>
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="product name or description..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📂 category:</label>
                <select 
                    name="category_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value=""> all category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📋 status:</label>
                <select 
                    name="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value=""> all status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>✅ approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>❌ rejected</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">👤 seller:</label>
                <select 
                    name="seller_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">all sellers</option>
                    @foreach($sellers as $seller)
                        <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>
                            {{ $seller->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 items-end">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition"
                >
                    🔍 Search
                    
                </button>
                <a 
                    href="{{ route('admin.products.index') }}" 
                    class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition text-center"
                >
                    🔄 Delete
                    
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">#</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">product name</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">seller</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">category</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">price</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">date</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">procedures</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $product->id }}</td>
                            <td class="px-6 py-4 text-sm font-semibold">
                                {{ substr($product->name, 0, 30) }}...
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('admin.sellers.show', $product->seller->id) }}" class="text-blue-600 hover:underline">
                                    {{ $product->seller->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $product->category->name }}</td>
                            <td class="px-6 py-4 text-sm font-semibold">{{ $product->price }} ر.س</td>
                            <td class="px-6 py-4">
                                @if($product->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">⏳ pending</span>
                                @elseif($product->status === 'approved')
                                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">✅ approved</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">❌ rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $product->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a 
                                    href="{{ route('admin.products.show', $product->id) }}" 
                                    class="text-blue-600 hover:text-blue-900 text-sm font-semibold"
                                >
                                    👁️ display
                                </a>
                                
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" class="inline"
                                      onsubmit="return confirm(' Are you sure you want to delete this product? ')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold ml-2">
                                        🗑️ delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <p>No products to display</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endsection