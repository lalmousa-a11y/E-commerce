@extends('layouts.admin')

@section('title', 'product details: ' . $product->name)
@section('page-title', '📦 product details: ' . $product->name)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            @if($product->files->count() > 0)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">🖼️  product photos</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($product->files as $file)
                            <div class="bg-gray-100 rounded-lg overflow-hidden">
                                <img 
                                    src="{{ asset('storage/' . $file->files) }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-40 object-cover"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📋 product information</h3>
                
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <p class="text-sm text-gray-600">product name:</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-sm text-gray-600">description:</p>
                        <p class="text-gray-900">{{ $product->description }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-sm text-gray-600">price:</p>
                        <p class="text-2xl font-bold text-green-600">{{ $product->price }} ر.س</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-sm text-gray-600">category:</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->category->name }}</p>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-sm text-gray-600">seller:</p>
                        <a 
                            href="{{ route('sellers.show', $product->seller->id) }}" 
                            class="text-lg font-semibold text-blue-600 hover:underline"
                        >
                            {{ $product->seller->name }}
                        </a>
                    </div>

                    <div class="border-b pb-3">
                        <p class="text-sm text-gray-600">created at:</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">⚙️  update status</h3>
                
                <form method="POST" action="{{ route('products.updateStatus', $product->id) }}" class="flex gap-3">
                    @csrf
                    
                    <select 
                        name="status"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="pending" {{ $product->status === 'pending' ? 'selected' : '' }}>⏳ pending</option>
                        <option value="approved" {{ $product->status === 'approved' ? 'selected' : '' }}>✅ approved</option>
                        <option value="rejected" {{ $product->status === 'rejected' ? 'selected' : '' }}>❌ rejected</option>
                    </select>
                    
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition"
                    >
                        💾 saved
                    </button>
                </form>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📊 current </h3>
                
                <div class="text-center">
                    @if($product->status === 'pending')
                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <p class="text-5xl mb-2">⏳</p>
                            <p class="text-lg font-bold text-yellow-800">pending</p>
                            <p class="text-sm text-yellow-600 mt-2"> waiting for admin review </p>
                        </div>
                    @elseif($product->status === 'approved')
                        <div class="bg-green-50 p-6 rounded-lg">
                            <p class="text-5xl mb-2">✅</p>
                            <p class="text-lg font-bold text-green-800">approved</p>
                            <p class="text-sm text-green-600 mt-2">ready for display and sale</p>
                        </div>
                    @else
                        <div class="bg-red-50 p-6 rounded-lg">
                            <p class="text-5xl mb-2">❌</p>
                            <p class="text-lg font-bold text-red-800">rejected</p>
                            <p class="text-sm text-red-600 mt-2">not displayed</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 space-y-3">
                <form method="POST" action="{{ route('products.destroy', $product->id) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition"
                    >
                        🗑️ delete product
                    </button>
                </form>

                <a 
                    href="{{ route('products.index') }}" 
                    class="w-full block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition text-center"
                >
                    ⬅️ back
                </a>
            </div>

            <div class="bg-blue-50 rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-bold text-blue-900 mb-3">ℹ️ information</h3>
                
                <div class="space-y-2 text-sm text-blue-800">
                    <p><strong> product id:</strong> {{ $product->id }}</p>
                    <p><strong>number of images:</strong> {{ $product->files->count() }}</p>
                    <p><strong>last updated:</strong> {{ $product->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection