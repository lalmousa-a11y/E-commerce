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
use App\Events\OrderConfirmed;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\OrderDiscountService;
use App\Services\Discounts\PercentageDiscount;
use App\Services\Discounts\FixedAmountDiscount;




class CheckoutController extends Controller
{
     protected $orderService;
    protected $paymentService;
    public function __construct(OrderService $orderService, PaymentService $paymentService)
    {
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }
   
    public function checkout(CheckoutRequest $request)
    {
        try {
            // Create order from cart
            $order = $this->orderService->createOrderFromCart(auth()->id());

            // Process payment
            $paymentResult = $this->paymentService->processPayment($order, [
                'card_number' => $request->card_number,
                'expiry' => $request->expiry,
                'cvv' => $request->cvv,
            ]);

            // Handle payment result
            if ($paymentResult['success'] && $paymentResult['status'] === 'SUCCESS') {
                $this->orderService->completeOrder($order, $paymentResult['transaction_id']);

                return response()->json([
                    'message' => 'Order completed successfully',
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'transaction_id' => $order->transaction_id,
                ], 200);
            }

            // Payment failed
            $this->orderService->failOrder($order);

            return response()->json([
                'message' => 'Payment failed',
                'status' => $order->status,
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->with('items.product')->get();
        return OrderResource::collection($orders);
    }

    public function applyDiscount(Request $request, Order $order, OrderDiscountService $discountService)
{
    $this->authorize('update', $order);

    $request->validate([
        'discount_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|min:0',
    ]);

    // All discount types are substitutable
    $discount = match($request->discount_type) {
        'percentage' => new PercentageDiscount($request->discount_value),
        'fixed' => new FixedAmountDiscount($request->discount_value),
    };

    $discountAmount = $discountService->applyDiscount($order, $discount);

    return response()->json([
        'message' => 'Discount applied successfully',
        'discount' => $discountAmount,
        'final_amount' => $order->final_amount,
    ]);
}

}
