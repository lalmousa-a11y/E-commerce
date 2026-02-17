<?php

namespace App\Services\PaymentGateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PayPalGateway implements PaymentGatewayInterface
{
    public function charge(Order $order, array $paymentData): array
    {
        $response = Http::post('https://api.paypal.com/v1/payments/payment', [
            'intent' => 'sale',
            'payer' => [
                'payment_method' => 'paypal'
            ],
            'transactions' => [[
                'amount' => [
                    'total' => $order->total_amount,
                    'currency' => 'USD'
                ]
            ]]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'success' => true,
                'status' => 'SUCCESS',
                'transaction_id' => $data['id'],
            ];
        }

        return [
            'success' => false,
            'status' => 'FAILED',
            'transaction_id' => null,
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        $response = Http::post("https://api.paypal.com/v1/payments/sale/{$transactionId}/refund", [
            'amount' => [
                'total' => $amount,
                'currency' => 'USD'
            ]
        ]);

        return [
            'success' => $response->successful(),
            'refund_id' => $response->json()['id'] ?? null,
        ];
    }

    public function getName(): string
    {
        return 'PayPal';
    }
}
