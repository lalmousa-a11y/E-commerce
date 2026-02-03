@extends('layouts.admin')

@section('title', ' order details: #' . $order->id)
@section('page-title', '📋 order details: #' . $order->id)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-bold">Order ID: #{{ $order->id }}</h2>
                        <p class="text-blue-100 mt-2">Order Date: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        @if($order->payment_status === 'pending')
                            <span class="bg-yellow-400 text-yellow-900 text-lg px-4 py-2 rounded-full font-semibold">⏳ pending</span>
                        @elseif($order->payment_status === 'paid')
                            <span class="bg-green-400 text-green-900 text-lg px-4 py-2 rounded-full font-semibold">✅ paid</span>
                        @else
                            <span class="bg-red-400 text-red-900 text-lg px-4 py-2 rounded-full font-semibold">❌ failed</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">👤 customer information</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">name:</p>
                        <p class="text-lg font-semibold">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">email:</p>
                        <p class="text-lg font-semibold">{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                    <h3 class="text-lg font-bold">📦 order items</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">product name</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">category</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">quantity</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">price</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('admin.products.show', $item->product->id) }}" class="text-blue-600 hover:underline">
                                            {{ substr($item->product->name, 0, 40) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $item->product->category->name }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $item->price }} ر.س</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-green-600">
                                        {{ $item->quantity * $item->price }} ر.س
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">💰 order summary</h3>

                <div class="space-y-4 mb-6 border-b pb-4">
                    <div class="flex justify-between">
                        <p class="text-gray-600">subtotal:</p>
                        <p class="font-semibold">{{ $order->total_amount }} ر.س</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-gray-600">tax:</p>
                        <p class="font-semibold">{{ $order->tax_amount ?? 0 }} ر.س</p>
                    </div>

                    <div class="flex justify-between">
                        <p class="text-gray-600">شحن:</p>
                        <p class="font-semibold">{{ $order->shipping_cost ?? 0 }} ر.س</p>
                    </div>
                </div>

                <div class="flex justify-between text-lg font-bold mb-6">
                    <p>total:</p>
                    <p class="text-green-600">{{ $order->total_amount }} ر.س</p>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <p class="text-sm text-gray-600"> Number of items:</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $order->items->count() }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">payment status:</p>
                    <div>
                        @if($order->payment_status === 'pending')
                            <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-semibold block text-center">
                                ⏳ pending
                            </span>
                        @elseif($order->payment_status === 'paid')
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold block text-center">
                                ✅ paid
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold block text-center">
                                ❌ failed
                            </span>
                        @endif
                    </div>
                </div>

                <a 
                    href="{{ route('admin.orders.index') }}" 
                    class="w-full mt-6 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg text-center"
                >
                    ⬅️ return
                </a>
            </div>
        </div>
    </div>
@endsection