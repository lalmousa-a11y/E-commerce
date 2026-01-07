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
            env('PAYMENT_API'),
            [
                'order_id' => $order->id,
                'total_amount' => $totalAmount,
                'card_number' => $request->card_number,
                'expiry' => $request->expiry,
                'cvv' => $request->cvv,
            ]
        );

        $status = 'FAILED';
        $transactionId = null;
        if($paymentResponse->successful()) {
        $paymentData = $paymentResponse->json();
        $status = $paymentData['status'] ?? 'FAILED';
        $transactionId = $paymentData['transaction_id'] ?? null;
    }
    

        if ($status === 'SUCCESS') {

            $order->update([
                'status' => 'COMPLETED',
                'payment_status' => 'PAID',
                'transaction_id' => $transactionId,]);

            CartItem::where('user_id', $user->id)->delete();

            return response()->json([
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'transaction_id' => $order->transaction_id,
            ], 200);
        }

        $order->update([
            'status' => 'FAILED',
            'payment_status' => 'FAILED',
        ]);

          return response()->json([
                 'status' => $order->status,
                  'payment_status' => $order->payment_status,
                  'transaction_id' => $order->transaction_id,
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