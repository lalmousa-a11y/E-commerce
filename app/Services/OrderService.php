<?php

namespace App\Services;

use App\Contracts\OrderRepositoryInterface;
use App\Contracts\NotificationServiceInterface;
use App\Contracts\CacheServiceInterface;
use App\Models\CartItem;
use App\Models\OrderItem;

class OrderService
{
    protected $orderRepository;
    protected $notificationService;
    protected $cacheService;

    // Depend on abstractions, not concrete classes
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        NotificationServiceInterface $notificationService,
        CacheServiceInterface $cacheService
    ) {
        $this->orderRepository = $orderRepository;
        $this->notificationService = $notificationService;
        $this->cacheService = $cacheService;
    }

    public function createOrderFromCart(int $userId)
    {
        $cartItems = CartItem::where('user_id', $userId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->qty * $item->product->price;
        });

        $order = $this->orderRepository->create([
            'user_id' => $userId,
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

        return $order;
    }

    public function completeOrder($order, string $transactionId)
    {
        $order = $this->orderRepository->update($order, [
            'status' => 'COMPLETED',
            'payment_status' => 'PAID',
            'transaction_id' => $transactionId,
        ]);

        CartItem::where('user_id', $order->user_id)->delete();
        
        // Use abstraction instead of direct Mail call
        $this->notificationService->sendOrderConfirmation($order, $order->user);
        
        // Clear cache
        $this->cacheService->forget("user_orders_{$order->user_id}");

        return $order;
    }

    public function failOrder($order)
    {
        $order = $this->orderRepository->update($order, [
            'status' => 'FAILED',
            'payment_status' => 'FAILED',
        ]);

        return $order;
    }

    public function getUserOrders(int $userId)
    {
        return $this->cacheService->remember(
            "user_orders_{$userId}",
            3600,
            fn() => $this->orderRepository->findByUser($userId)
        );
    }
}
