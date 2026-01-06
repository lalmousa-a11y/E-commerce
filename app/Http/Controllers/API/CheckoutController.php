<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\OrderResource;



class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
    

        $user = auth()->user();

        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 400);
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->qty * $item->product->price;
        });

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'PENDING',
            'payment_status' => 'UNPAID',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->qty,
                'price_at_purchase' => $item->product->price,
            ]);
        }

        $paymentResponse = Http::post(
            'https://e-commerce-api.free.beeceptor.com/payment',
            [
                'order_id' => $order->id,
                'total_amount' => $totalAmount,
                'card_number' => $request->card_number,
                'expiry' => $request->expiry,
                'cvv' => $request->cvv,
            ]
        );

        $paymentData = $paymentResponse->json();

        if ($paymentData['status'] === 'success') {

            $order->update([
                'status' => 'COMPLETED',
                'payment_status' => 'PAID',
                'transaction_id' => $paymentData['transaction_id'] ?? null,
            ]);

            CartItem::where('user_id', $user->id)->delete();

            return response()->json(['order' => new OrderResource($order)], 200);
        }

        $order->update([
            'status' => 'FAILED',
            'payment_status' => 'FAILED',
        ]);

          return response()->json([
              'order' => new OrderResource($order),
             'message' => 'Payment failed'
                ], 400);
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->get();

        return response()->json(['orders' => OrderResource::collection($orders)], 200);
    }
}