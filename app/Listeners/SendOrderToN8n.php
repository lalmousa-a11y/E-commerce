<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderConfirmed;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendOrderToN8n
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderConfirmed $event): void
    {
        $order = $event->order;
        log::info('Sending order to n8n', ['order_id' => $order->id]);
        Http::post(config('services.n8n.webhook'), [
            'order_id' => $order->id,
            'total_amount' => $order->total_amount,
            'payment_status' => $order->payment_status,
            'created_at' => $order->created_at,
            

            'customer_name' => [
                'name' => $order->user->name,
                'email' => $order->user->email,
            ]
        ]);
    }
}
