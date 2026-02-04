@extends('layouts.admin')

@section('title', ' orders management')
@section('page-title', '📋 orders management')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">🔍 search:</label>
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="order number or name..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">💳 payment status:</label>
                <select 
                    name="payment_status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="">all statuses</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>⏳ pending</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>✅ paid</option>
                    <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>❌ failed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📅 from:</label>
                <input 
                    type="date" 
                    name="from_date"
                    value="{{ request('from_date') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">📅 to:</label>
                <input 
                    type="date" 
                    name="to_date"
                    value="{{ request('to_date') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="flex gap-2 items-end">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition"
                >
                    🔍 search
                </button>
                <a 
                    href="{{ route('admin.orders.index') }}" 
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
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">order number</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">customer</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">amount</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">payment status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">number of items</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">date</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">procedure</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-semibold">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:underline">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 text-sm font-semibold">{{ $order->total_amount }} ر.س</td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full">⏳ pending</span>
                                @elseif($order->payment_status === 'paid')
                                    <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">✅ paid</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full">❌ failed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $order->items->count() }} items</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a 
                                    href="{{ route('admin.orders.show', $order->id) }}" 
                                    class="text-blue-600 hover:text-blue-900 text-sm font-semibold"
                                >
                                    👁️ Display
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <p>no orders to display</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection