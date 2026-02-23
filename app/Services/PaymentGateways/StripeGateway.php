<?php

namespace App\Services\PaymentGateways;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class StripeGateway implements PaymentGatewayInterface
{
    public function charge(Order $order, array $paymentData): array
    {
        // Check if required payment data is present
        if (!isset($paymentData['card_number']) || !isset($paymentData['expiry']) || !isset($paymentData['cvv'])) {
            return [
                'success' => false,
                'status' => 'FAILED',
                'transaction_id' => null,
                'error' => 'Missing required payment information: card_number, expiry, or cvv',
            ];
        }

        // Set Stripe API key
        \Stripe\Stripe::setApiKey(config('payment.stripe.secret_key'));

        try {
            // Create a payment intent with Stripe
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => (int)($order->total_amount * 100), // Stripe uses cents
                'currency' => 'usd',
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'number' => $paymentData['card_number'],
                        'exp_month' => (int)explode('/', $paymentData['expiry'])[0],
                        'exp_year' => (int)explode('/', $paymentData['expiry'])[1],
                        'cvc' => $paymentData['cvv'],
                    ],
                ],
                'confirm' => true,
                'return_url' => url('/api/checkout/confirm'),
            ]);

            if ($paymentIntent && $paymentIntent->status === 'succeeded') {
                return [
                    'success' => true,
                    'status' => 'SUCCESS',
                    'transaction_id' => $paymentIntent->id,
                ];
            }

            return [
                'success' => false,
                'status' => 'FAILED',
                'transaction_id' => null,
                'error' => 'Payment intent status: ' . ($paymentIntent->status ?? 'unknown'),
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'status' => 'FAILED',
                'transaction_id' => null,
                'error' => 'Payment failed: ' . $e->getMessage(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'status' => 'FAILED',
                'transaction_id' => null,
                'error' => 'Payment error: ' . $e->getMessage(),
            ];
        }
    }

    public function refund(string $transactionId, float $amount): array
    {
        $response = Http::post("https://api.stripe.com/v1/refunds", [
            'charge' => $transactionId,
            'amount' => $amount * 100,
        ]);

        return [
            'success' => $response->successful(),
            'refund_id' => $response->json()['id'] ?? null,
        ];
    }

    public function getName(): string
    {
        return 'Stripe';
    }
}
