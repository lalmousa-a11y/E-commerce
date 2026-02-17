<?php

namespace App\Services;

use App\Contracts\NotificationServiceInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use App\Mail\OrderShipped;
use App\Mail\PaymentReceived;

class EmailNotificationService implements NotificationServiceInterface
{
    public function sendOrderConfirmation($order, $user)
    {
        Mail::to($user->email)->send(new OrderConfirmed($order));
    }

    public function sendOrderShipped($order, $user)
    {
        Mail::to($user->email)->send(new OrderShipped($order));
    }

    public function sendPaymentReceived($order, $user)
    {
        Mail::to($user->email)->send(new PaymentReceived($order));
    }
}
