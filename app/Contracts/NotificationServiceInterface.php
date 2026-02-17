<?php

namespace App\Contracts;

interface NotificationServiceInterface
{
    public function sendOrderConfirmation($order, $user);
    public function sendOrderShipped($order, $user);
    public function sendPaymentReceived($order, $user);
}
