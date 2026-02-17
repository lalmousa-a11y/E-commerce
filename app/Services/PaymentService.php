<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Contracts\PaymentGatewayInterface;

class PaymentService
{
  
    protected $gateway;

    public function __construct(PaymentGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processPayment(Order $order, array $paymentData): array
    {
        return $this->gateway->charge($order, $paymentData);
    }

    public function refundPayment(string $transactionId, float $amount): array
    {
        return $this->gateway->refund($transactionId, $amount);
    }

    public function getGatewayName(): string
    {
        return $this->gateway->getName();
    }
}

