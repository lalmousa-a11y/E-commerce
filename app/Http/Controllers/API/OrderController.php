<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    protected $orderService;

    // Depend on abstraction (service), not concrete implementation
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function myOrders()
    {
        $orders = $this->orderService->getUserOrders(auth()->id());
        return OrderResource::collection($orders);
    }
}
