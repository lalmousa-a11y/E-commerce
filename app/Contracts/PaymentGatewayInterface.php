<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function charge(Order $order, array $paymentData): array;
    public function refund(string $transactionId, float $amount): array;
    public function getName(): string;
}
